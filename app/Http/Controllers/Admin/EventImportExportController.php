<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EventImportExportController extends Controller
{
    /**
     * 🟩 Export all events as CSV (simplified, without IDs and timestamps)
     */
    public function export()
    {
        $events = Event::all();

        $headers = [
            'event_name',
            'type',
            'description',
            'venue',
            'event_date',
            'event_time',
            'is_group',
            'max_group_size',
            'max_participants',
            'registration_open',
            'thumbnail_image',
            'carousel_image_1',
            'carousel_image_2',
            'carousel_image_3',
            'carousel_image_4',
            'carousel_image_5'
        ];

        $filename = "events_export_" . now()->format('Y_m_d_H_i') . ".csv";
        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, $headers);

        foreach ($events as $event) {
            fputcsv($handle, [
                $event->event_name,
                $event->type,
                $event->description,
                $event->venue,
                $event->event_date,
                $event->event_time,
                $event->is_group,
                $event->max_group_size,
                $event->max_participants,
                $event->registration_open,
                $event->thumbnail_image,
                $event->carousel_image_1,
                $event->carousel_image_2,
                $event->carousel_image_3,
                $event->carousel_image_4,
                $event->carousel_image_5
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * 🟦 Import events from CSV (simplified, without IDs and timestamps)
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');

        $header = fgetcsv($handle);
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            if (!$data || empty($data['event_name'])) {
                continue; // skip empty rows
            }

            Event::create([
                'event_name'         => $data['event_name'] ?? null,
                'type'               => $data['type'] ?? null,
                'description'        => $data['description'] ?? null,
                'venue'              => $data['venue'] ?? null,
                'event_date'         => $data['event_date'] ?? null,
                'event_time'         => $data['event_time'] ?? null,
                'is_group'           => !empty($data['is_group']) ? (int)$data['is_group'] : 0,
                'max_group_size'     => !empty($data['max_group_size']) ? (int)$data['max_group_size'] : null,
                'max_participants'   => !empty($data['max_participants']) ? (int)$data['max_participants'] : null,
                'registration_open'  => !empty($data['registration_open']) ? (int)$data['registration_open'] : 0,
                'thumbnail_image'    => $data['thumbnail_image'] ?? null,
                'carousel_image_1'   => $data['carousel_image_1'] ?? null,
                'carousel_image_2'   => $data['carousel_image_2'] ?? null,
                'carousel_image_3'   => $data['carousel_image_3'] ?? null,
                'carousel_image_4'   => $data['carousel_image_4'] ?? null,
                'carousel_image_5'   => $data['carousel_image_5'] ?? null
            ]);

            $count++;
        }

        fclose($handle);

        return redirect()->back()->with('success', "✅ $count events imported successfully!");
    }
}
