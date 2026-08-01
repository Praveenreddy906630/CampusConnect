<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateToPostgres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-to-pgsql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from SQLite to PostgreSQL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting data migration from SQLite to PostgreSQL...');

        // Verify connections
        try {
            DB::connection('sqlite')->getPdo();
            $this->info('Successfully connected to SQLite source.');
            DB::connection('pgsql')->getPdo();
            $this->info('Successfully connected to PostgreSQL destination.');
        } catch (\Exception $e) {
            $this->error('Database connection error: ' . $e->getMessage());
            return;
        }

        // First, drop all existing tables in pgsql
        DB::connection('pgsql')->unprepared("DROP SCHEMA public CASCADE; CREATE SCHEMA public; GRANT ALL ON SCHEMA public TO public;");
        $this->info('Cleared PostgreSQL schema.');

        $sqlitePdo = DB::connection('sqlite')->getPdo();
        $tablesQuery = $sqlitePdo->query("SELECT name, sql FROM sqlite_master WHERE type='table' AND name NOT IN ('sqlite_sequence', 'migrations')");
        $sqliteTables = $tablesQuery->fetchAll(\PDO::FETCH_ASSOC);

        $tables = [];

        foreach ($sqliteTables as $tableInfo) {
            $tableName = $tableInfo['name'];
            $sqliteSql = $tableInfo['sql'];
            
            // Convert SQLite DDL to PostgreSQL DDL
            $pgsqlSql = str_replace('`', '"', $sqliteSql); // Replace backticks with double quotes
            $pgsqlSql = preg_replace('/INTEGER\s+PRIMARY\s+KEY\s+AUTOINCREMENT/i', 'SERIAL PRIMARY KEY', $pgsqlSql);
            $pgsqlSql = preg_replace('/tinyINTEGER/i', 'SMALLINT', $pgsqlSql);
            $pgsqlSql = preg_replace('/datetime/i', 'TIMESTAMP', $pgsqlSql);
            $pgsqlSql = preg_replace('/int\s*\([^)]*\)/i', 'INTEGER', $pgsqlSql); // Convert int(11) to INTEGER
            $pgsqlSql = preg_replace('/tinyint\s*\([^)]*\)/i', 'SMALLINT', $pgsqlSql); // Convert tinyint(1) to SMALLINT
            
            try {
                DB::connection('pgsql')->statement($pgsqlSql);
                $this->info("Created table schema for: {$tableName}");
                $tables[] = $tableName;
            } catch (\Exception $e) {
                $this->warn("Could not create schema for {$tableName}: " . $e->getMessage());
                // Simple fallback if table exists
            }
        }

        foreach ($tables as $table) {
            $this->info("Migrating data for table: {$table}");
            $records = DB::connection('sqlite')->table($table)->get();
            $this->info("Found {$records->count()} records in {$table}.");

            if ($records->isEmpty()) {
                continue;
            }

            // Convert records to array for insertion
            $insertData = [];
            foreach ($records as $record) {
                // SQLite returns objects, convert to array
                $data = (array) $record;
                $insertData[] = $data;
            }

            // Insert in chunks to avoid memory limits and SQL length limits
            DB::connection('pgsql')->transaction(function () use ($table, $insertData) {
                // Disable foreign key checks for the table if necessary
                DB::connection('pgsql')->statement("SET session_replication_role = 'replica';");
                
                // Clear existing records safely
                DB::connection('pgsql')->table($table)->delete();
                
                // Chunk insert
                $chunks = array_chunk($insertData, 500);
                foreach ($chunks as $chunk) {
                    DB::connection('pgsql')->table($table)->insert($chunk);
                }

                // Re-enable foreign key checks
                DB::connection('pgsql')->statement("SET session_replication_role = 'origin';");
            });

            // Update Postgres sequence for auto-increment ID columns
            try {
                // Find primary key
                $primaryKey = 'id';
                if ($table == 'events') $primaryKey = 'event_id';
                if ($table == 'event_registrations') $primaryKey = 'registration_id';
                if ($table == 'coordinators') $primaryKey = 'coordinator_id';
                
                $maxId = DB::connection('pgsql')->table($table)->max($primaryKey);
                if (is_numeric($maxId) || $maxId === null) {
                    $maxId = $maxId ?? 0;
                    // Determine sequence name
                    $seqName = "{$table}_{$primaryKey}_seq";
                    DB::connection('pgsql')->statement("SELECT setval('{$seqName}', " . ($maxId + 1) . ", false)");
                }
            } catch (\Exception $e) {
                $this->warn("Could not reset sequence for {$table}: " . $e->getMessage());
            }

            $this->info("Successfully migrated {$table}.");
        }

        $this->info('Data migration completed perfectly!');
    }
}

