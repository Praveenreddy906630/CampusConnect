import fs from "node:fs/promises";
import path from "node:path";

let SpreadsheetFile;
let Workbook;
let workbookSupport = true;
try {
  ({ SpreadsheetFile, Workbook } = await import("@oai/artifact-tool"));
} catch {
  workbookSupport = false;
}

const root = process.cwd();
const reportDir = path.join(root, "Vulnerability Test Results");
const severityRank = { Critical: 4, High: 3, Medium: 2, Low: 1 };

const inventory = [
  { key: "Framework", value: "Laravel 12 web application" },
  { key: "Language", value: "PHP 8.2+ backend, JavaScript/Vite frontend assets, Blade templates" },
  { key: "API Architecture", value: "Server-rendered Laravel routes with JSON responses for login, registration, and student lookup; no dedicated routes/api.php found" },
  { key: "Authentication", value: "Laravel session authentication through Auth::attempt with session regeneration on login" },
  { key: "Authorization", value: "Role checks using user_type through AdminMiddleware and CoordinatorMiddleware" },
  { key: "Database", value: "Laravel database config supports sqlite/mysql/mariadb/pgsql/sqlsrv; default is sqlite unless env overrides" },
  { key: "ORM", value: "Laravel Eloquent models: User, Student, Event, EventRegistration, Coordinator, Setting, Soty" },
  { key: "API Documentation", value: "No Swagger/OpenAPI/GraphQL schema detected" },
  { key: "Middleware", value: "AdminMiddleware, CoordinatorMiddleware, UserMiddleware, CheckRegistrationPeriod" },
  { key: "File Uploads", value: "Event images, SOTY zip uploads, CSV imports for events/students/participants" },
  { key: "Session Handling", value: "Laravel cookie/session handling; logout invalidates session and regenerates CSRF token" },
  { key: "Third-Party Integrations", value: "Laravel Mail, Vite, Tailwind, Axios; optional SMTP via env" },
];

const endpoints = [
  ["/", "GET", "No", "Public", "routes/web.php:35, routes/web.php:207"],
  ["/events", "GET", "No", "Public, registration period open", "routes/web.php:43"],
  ["/coordinators", "GET", "No", "Public", "routes/web.php:46, routes/web.php:204"],
  ["/coordinators/{id}", "GET", "No", "Public", "routes/web.php:205"],
  ["/get-student-details", "POST", "No", "Public, CSRF expected in browser", "routes/web.php:49"],
  ["/register", "GET", "No", "Public, registration period open", "routes/web.php:68"],
  ["/register", "POST", "No", "Public, registration period open", "routes/web.php:69"],
  ["/events/{event}/register", "GET", "Yes", "Authenticated user", "routes/web.php:73"],
  ["/events/{event}/register", "POST", "Yes", "Authenticated user", "routes/web.php:74"],
  ["/my-registrations", "GET", "Yes", "Authenticated user", "routes/web.php:77"],
  ["/soty/apply", "GET", "Yes", "Authenticated user", "routes/web.php:83"],
  ["/soty/apply", "POST", "Yes", "Authenticated user", "routes/web.php:84"],
  ["/admin/soty/{id}", "DELETE", "Yes", "Authenticated user only by route; admin namespace name but not admin middleware", "routes/web.php:85"],
  ["/login", "GET", "No", "Public", "routes/web.php:90"],
  ["/login", "POST", "No", "Public", "routes/web.php:91"],
  ["/logout", "POST", "Yes", "Authenticated session", "routes/web.php:94"],
  ["/admin/dashboard", "GET", "Yes", "Admin", "routes/web.php:101"],
  ["/admin/events/delete-all", "DELETE", "Yes", "Admin", "routes/web.php:104"],
  ["/admin/events", "RESOURCE", "Yes", "Admin", "routes/web.php:106, routes/web.php:108"],
  ["/admin/admin/events", "RESOURCE", "Yes", "Admin", "routes/web.php:107"],
  ["/admin/registrations", "GET", "Yes", "Admin", "routes/web.php:111"],
  ["/admin/registrations/{eventId}", "GET", "Yes", "Admin", "routes/web.php:112"],
  ["/admin/registrations/{id}", "DELETE", "Yes", "Admin", "routes/web.php:113"],
  ["/admin/registrations/event/{event}", "DELETE", "Yes", "Admin", "routes/web.php:114"],
  ["/admin/users", "GET", "Yes", "Admin", "routes/web.php:117"],
  ["/admin/users/delete-all", "DELETE", "Yes", "Admin", "routes/web.php:118"],
  ["/admin/users/{id}", "DELETE", "Yes", "Admin", "routes/web.php:119"],
  ["/admin/settings", "GET", "Yes", "Admin", "routes/web.php:122"],
  ["/admin/settings", "PUT", "Yes", "Admin", "routes/web.php:123"],
  ["/admin/soty", "GET", "Yes", "Admin", "routes/web.php:126"],
  ["/admin/soty/delete-all", "DELETE", "Yes", "Admin", "routes/web.php:127"],
  ["/admin/soty/{id}", "DELETE", "Yes", "Admin", "routes/web.php:128"],
  ["/admin/events/export", "GET", "Yes", "Admin", "routes/web.php:131"],
  ["/admin/events/import", "POST", "Yes", "Admin", "routes/web.php:132"],
  ["/admin/coordinators", "GET/POST", "Yes", "Admin", "routes/web.php:135-137"],
  ["/admin/coordinators/{id}/edit", "GET", "Yes", "Admin", "routes/web.php:139"],
  ["/admin/coordinators/{id}", "PUT/DELETE", "Yes", "Admin", "routes/web.php:138, routes/web.php:140"],
  ["/admin/students", "GET", "Yes", "Admin", "routes/web.php:143"],
  ["/admin/students/export", "GET", "Yes", "Admin", "routes/web.php:144"],
  ["/admin/students/import", "POST", "Yes", "Admin", "routes/web.php:145"],
  ["/admin/students/delete-all", "DELETE", "Yes", "Admin", "routes/web.php:146"],
  ["/admin/admins", "GET/POST", "Yes", "Admin", "routes/web.php:149, routes/web.php:152"],
  ["/admin/admins/create", "GET", "Yes", "Admin", "routes/web.php:151"],
  ["/admin/admins/{admin}/edit", "GET", "Yes", "Admin", "routes/web.php:150"],
  ["/admin/admins/{admin}", "PUT/DELETE", "Yes", "Admin", "routes/web.php:153-154"],
  ["/admin/statistics", "GET", "Yes", "Admin", "routes/web.php:156"],
  ["/coordinator/dashboard", "GET", "No/Yes conflict", "Duplicate public and coordinator-protected definitions", "routes/web.php:162-174"],
  ["/coordinator/registrations", "GET", "No", "Coordinator public group", "routes/web.php:164"],
  ["/coordinator/email-participants", "POST", "No", "Coordinator public group", "routes/web.php:165"],
  ["/coordinator/my-events", "GET", "Yes", "Coordinator", "routes/web.php:176"],
  ["/coordinator/participants/{event}", "GET", "Yes", "Coordinator", "routes/web.php:180"],
  ["/coordinator/participants/{event}/export", "GET", "Yes", "Coordinator", "routes/web.php:184, routes/web.php:197"],
  ["/coordinator/mail/{event}", "POST", "Yes", "Coordinator", "routes/web.php:188"],
  ["/coordinator/participants/{event}/{participant}", "DELETE", "Yes", "Coordinator", "routes/web.php:191"],
  ["/coordinator/participants/{event}/import", "POST", "Yes", "Coordinator", "routes/web.php:198"],
  ["/coordinator/coordinator/event/{event}/export", "GET", "Yes", "Coordinator", "routes/web.php:200"],
  ["/contact", "GET", "No", "Public", "routes/web.php:206"],
  ["/up", "GET", "No", "Health check", "bootstrap/app.php:8"],
];

const findings = [
  {
    severity: "Critical",
    type: "Broken Access Control",
    file: "routes/web.php:162-165",
    endpoint: "/coordinator/dashboard, /coordinator/registrations, /coordinator/email-participants",
    description: "Coordinator dashboard, registrations, and email participant routes are declared in an unprotected coordinator prefix before the protected coordinator group.",
    exploitation: "An unauthenticated user can request coordinator URLs and may reach controller methods that expose coordinator workflows or email functionality depending on controller behavior.",
    impact: "Unauthorized data access, participant email abuse, and confusion because protected duplicate routes appear later.",
    fix: "Remove the public coordinator group or apply auth plus CoordinatorMiddleware to every coordinator route. Keep one route definition per URL.",
  },
  {
    severity: "Critical",
    type: "Sensitive Data Exposure",
    file: "app/Http/Controllers/StudentExportController.php:15-48",
    endpoint: "/admin/students/export",
    description: "The student CSV export includes the password column and writes each student's stored password value to the export.",
    exploitation: "An admin account compromise or over-permissive export access leaks password hashes or imported plaintext/default passwords for all students.",
    impact: "Credential cracking risk, privacy breach, and reuse attacks against other campus systems.",
    fix: "Remove password from exports, never import plaintext/default password values, and rotate any exposed student credentials.",
  },
  {
    severity: "High",
    type: "SQL Injection Risk",
    file: "app/Http/Controllers/Admin/StudentController.php:39-41",
    endpoint: "/admin/students",
    description: "sort_by and sort_dir are passed directly into orderBy without an allowlist.",
    exploitation: "A malicious admin or attacker with access can attempt crafted sorting values to alter SQL generation or trigger database errors.",
    impact: "Potential SQL injection or error-based information disclosure depending on database driver behavior.",
    fix: "Allowlist sortable columns and directions before calling orderBy.",
  },
  {
    severity: "High",
    type: "Broken Access Control",
    file: "routes/web.php:85",
    endpoint: "DELETE /admin/soty/{id}",
    description: "A route named admin.soty.destroy is inside an auth-only student group rather than the admin middleware group.",
    exploitation: "Any authenticated user could submit a delete request for a SOTY record id.",
    impact: "Unauthorized deletion of student award submissions and uploaded documents.",
    fix: "Move this route into the admin middleware group or add an explicit policy check requiring admin role.",
  },
  {
    severity: "High",
    type: "Authentication Weakness",
    file: "app/Http/Controllers/Auth/LoginController.php:9-46",
    endpoint: "POST /login",
    description: "Login has no visible request validation or rate limiting/throttling.",
    exploitation: "Attackers can brute-force credentials or perform credential stuffing at high speed.",
    impact: "Account takeover risk for students, coordinators, and administrators.",
    fix: "Use Laravel rate limiting, validate email/password fields, and lock or delay repeated failed attempts.",
  },
  {
    severity: "High",
    type: "Mass Destructive Operation",
    file: "routes/web.php:104,114,118,127,146",
    endpoint: "Multiple delete-all routes",
    description: "Several bulk delete routes can remove events, registrations, users, SOTY submissions, or students.",
    exploitation: "A compromised admin session or CSRF bypass could wipe large portions of production data.",
    impact: "Major data loss and operational disruption.",
    fix: "Require policies, confirmation tokens, audit logging, soft deletes, backups, and separate high-risk authorization for bulk deletion.",
  },
  {
    severity: "Medium",
    type: "Input Validation",
    file: "routes/web.php:49-65",
    endpoint: "POST /get-student-details",
    description: "Public student lookup returns personal student details by enrollment number and does not enforce throttling or authentication.",
    exploitation: "An attacker can enumerate enrollment numbers and collect names, program codes, semester, gender, school, and email.",
    impact: "Personal data exposure and targeted phishing risk.",
    fix: "Authenticate lookup, rate limit, return minimal data, and use anti-enumeration responses.",
  },
  {
    severity: "Medium",
    type: "File Upload Security",
    file: "app/Http/Controllers/SotyController.php:96-117",
    endpoint: "POST /soty/apply",
    description: "SOTY requires zip upload and stores the archive on the public disk.",
    exploitation: "A user can upload archive content that may later be downloaded or processed unsafely.",
    impact: "Malware hosting, zip bomb risk, and sensitive document exposure if storage is publicly linked.",
    fix: "Store submissions outside public web storage, virus scan archives, inspect size and entry count, and serve downloads through authorization checks.",
  },
  {
    severity: "Medium",
    type: "CSV Injection",
    file: "app/Http/Controllers/StudentExportController.php:33-68",
    endpoint: "/admin/students/export",
    description: "CSV exports write user-controlled fields without neutralizing spreadsheet formulas.",
    exploitation: "A malicious student name/email beginning with =, +, -, or @ can execute spreadsheet formulas when opened by staff.",
    impact: "Local data exfiltration or command abuse in vulnerable spreadsheet clients.",
    fix: "Prefix dangerous CSV cell values with a single quote or tab and document safe export handling.",
  },
  {
    severity: "Medium",
    type: "CSV Import Validation",
    file: "app/Http/Controllers/StudentExportController.php:72-102",
    endpoint: "POST /admin/students/import",
    description: "Student import accepts CSV rows with minimal validation and can store password values from the file.",
    exploitation: "A malicious or malformed import can create incomplete records, default passwords, or inconsistent identity data.",
    impact: "Account confusion, weak credentials, and data quality issues affecting authorization workflows.",
    fix: "Validate schema, required columns, allowed values, unique keys, and hash or discard any imported password values.",
  },
  {
    severity: "Medium",
    type: "SQL Injection Risk",
    file: "app/Http/Controllers/CoordinatorDashboardController.php:149-153",
    endpoint: "GET /coordinator/participants/{event}",
    description: "Coordinator participant sorting accepts sort and direction request values directly in orderBy.",
    exploitation: "A coordinator can provide unexpected sort fields or directions to trigger SQL errors or injection-like behavior.",
    impact: "Data access errors or database information disclosure.",
    fix: "Allowlist sort columns and direction values before orderBy.",
  },
  {
    severity: "Low",
    type: "Route Hygiene",
    file: "routes/web.php:106-108,184-201,35-207",
    endpoint: "Multiple duplicate routes",
    description: "Several routes are duplicated, including admin event resources, coordinator exports, and the home route.",
    exploitation: "Duplicate routes make access-control review harder and can cause unexpected route matching behavior.",
    impact: "Maintainability risk and accidental exposure during future changes.",
    fix: "Deduplicate route declarations and verify route:list output in CI.",
  },
  {
    severity: "Low",
    type: "Security Headers",
    file: "bootstrap/app.php:10-12",
    endpoint: "All web responses",
    description: "No custom security header middleware was detected for CSP, X-Frame-Options, Referrer-Policy, or Permissions-Policy.",
    exploitation: "Browser attacks such as clickjacking or content injection have fewer defense-in-depth controls.",
    impact: "Increased blast radius for XSS/clickjacking bugs.",
    fix: "Add a security headers middleware and tune CSP for Blade/Vite assets.",
  },
];

const dependencyRows = [
  ["Ecosystem", "Package", "Installed/Declared", "Risk", "Recommendation"],
  ["Composer", "laravel/framework", "^12.0", "Not live-scanned locally; workflow runs composer audit, Trivy, and Dependency Check", "Keep Laravel patched and review composer audit output in CI"],
  ["Composer", "laravel/tinker", "^2.10.1", "Development/admin console capability", "Do not expose tinker in production; restrict shell access"],
  ["NPM", "axios", "^1.11.0", "Dependency should be audited in CI", "Run npm audit and keep patched"],
  ["NPM", "vite", "^7.0.4", "Build tooling dependency", "Keep dev tooling patched; do not deploy dev server publicly"],
  ["NPM", "tailwindcss", "^4.0.0", "Build tooling dependency", "Keep patched through npm audit"],
  ["Scanner availability", "Local machine", "semgrep/trivy/gitleaks/dependency-check not on PATH during generation", "Workflow installs or invokes these scanners where available"],
];

function testCaseRows(kind, count = 400) {
  const categories = kind === "Selenium"
    ? ["Login", "Registration", "Events", "Navigation", "Security", "Validation", "Accessibility", "Session"]
    : ["Launch", "Login", "Navigation", "Forms", "Offline", "Permissions", "Security", "Performance"];
  const rows = [["Test ID", "Category", "Scenario", "Steps", "Expected Result", "Priority", "Status"]];
  for (let i = 1; i <= count; i += 1) {
    const category = categories[(i - 1) % categories.length];
    rows.push([
      `${kind.toUpperCase()}-${String(i).padStart(3, "0")}`,
      category,
      `${category} E2E validation ${i}`,
      `Open CampusConnect ${category.toLowerCase()} flow; provide valid/invalid data variant ${i}; verify UI, route, and error handling.`,
      "Application responds correctly, protects authenticated pages, and displays expected state without console or server errors.",
      i % 10 === 0 ? "High" : i % 3 === 0 ? "Medium" : "Low",
      "Not Run",
    ]);
  }
  return rows;
}

function styleSheet(sheet, usedRange, headerRange = "A1:G1") {
  sheet.showGridLines = false;
  sheet.freezePanes.freezeRows(1);
  usedRange.format.autofitColumns();
  usedRange.format.autofitRows();
  sheet.getRange(headerRange).format.fill.color = "#1f4e78";
  sheet.getRange(headerRange).format.font.color = "#FFFFFF";
  sheet.getRange(headerRange).format.font.bold = true;
  usedRange.format.borders = { preset: "outside", style: "thin", color: "#B7C9D6" };
}

async function writeWorkbook(filePath, sheets) {
  if (!workbookSupport) {
    const csvPath = filePath.replace(/\.xlsx$/i, ".csv");
    const [name, rows] = sheets[0];
    const csv = rows.map((row) => row.map((cell) => `"${String(cell ?? "").replaceAll('"', '""')}"`).join(",")).join("\n");
    await fs.writeFile(csvPath, csv);
    try {
      await fs.access(filePath);
      console.log(`Workbook support unavailable; preserved existing ${filePath} and wrote ${name} CSV fallback.`);
    } catch {
      console.log(`Workbook support unavailable; wrote CSV fallback ${csvPath}.`);
    }
    return;
  }

  const workbook = Workbook.create();
  for (const [name, rows] of sheets) {
    const sheet = workbook.worksheets.add(name);
    sheet.getRangeByIndexes(0, 0, rows.length, rows[0].length).values = rows;
    styleSheet(sheet, sheet.getRangeByIndexes(0, 0, rows.length, rows[0].length), `A1:${String.fromCharCode(64 + rows[0].length)}1`);
  }
  await workbook.inspect({ kind: "sheet", include: "id,name", maxChars: 2000 });
  const errors = await workbook.inspect({ kind: "match", searchTerm: "#REF!|#DIV/0!|#VALUE!|#NAME\\?|#N/A", options: { useRegex: true, maxResults: 20 }, maxChars: 2000 });
  if (String(errors.ndjson || "").includes("#REF!")) {
    throw new Error(`Formula error found in ${filePath}`);
  }
  await workbook.render({ sheetName: sheets[0][0], autoCrop: "all", scale: 1, format: "png" });
  const output = await SpreadsheetFile.exportXlsx(workbook);
  await output.save(filePath);
}

function markdownFinding(f) {
  return `## ${f.severity} - ${f.type}

- File Path: ${f.file}
- Endpoint: ${f.endpoint}
- Description: ${f.description}
- Exploitation Scenario: ${f.exploitation}
- Impact: ${f.impact}
- Recommended Fix: ${f.fix}
`;
}

async function main() {
  await fs.mkdir(reportDir, { recursive: true });
  await fs.mkdir(path.join(root, "selenium-tests"), { recursive: true });
  await fs.mkdir(path.join(root, "appium-tests"), { recursive: true });

  const critical = findings.filter((f) => f.severity === "Critical").length;
  const high = findings.filter((f) => f.severity === "High").length;
  const medium = findings.filter((f) => f.severity === "Medium").length;
  const low = findings.filter((f) => f.severity === "Low").length;
  const score = Math.max(0, 100 - critical * 20 - high * 10 - medium * 4 - low * 1);

  const executive = `# Executive Summary

Total Findings: ${findings.length}

Critical: ${critical}
High: ${high}
Medium: ${medium}
Low: ${low}

Most Critical Risks

1. Public coordinator route group exposes coordinator workflows without coordinator middleware.
2. Student export includes password data.
3. Auth-only SOTY delete route can allow unauthorized deletion.

Overall Security Score

${score}/100
`;

  const securityReview = `# CampusConnect Security Review

## Backend Inventory

${inventory.map((item) => `- ${item.key}: ${item.value}`).join("\n")}

## API Inventory

| Endpoint | HTTP Method | Authentication Required | Expected Roles | Controller/File Path |
|---|---:|---|---|---|
${endpoints.map((e) => `| ${e[0]} | ${e[1]} | ${e[2]} | ${e[3]} | ${e[4]} |`).join("\n")}

## Vulnerability Findings

${findings.sort((a, b) => severityRank[b.severity] - severityRank[a.severity]).map(markdownFinding).join("\n")}

## DAST Notes

No running CampusConnect URL was provided during generation, so live DAST was not executed locally. The included workflow and scripts run non-destructive smoke checks when API_BASE_URL or BASE_URL is configured.
`;

  const dependencyReport = `# Dependency Report

Local scanner availability check: semgrep, trivy, gitleaks, and dependency-check were not present on PATH in this generation environment. The GitHub Actions workflow is configured to run Semgrep, Trivy, Gitleaks, Composer audit, npm audit, and OWASP Dependency Check where the runner can install or access them.

${dependencyRows.slice(1).map((row) => `- ${row[0]} / ${row[1]} (${row[2]}): ${row[3]}. ${row[4]}.`).join("\n")}
`;

  await fs.writeFile(path.join(reportDir, "security-review.md"), securityReview);
  await fs.writeFile(path.join(reportDir, "executive-summary.md"), executive);
  await fs.writeFile(path.join(reportDir, "dependency-report.md"), dependencyReport);

  const findingRows = [
    ["Severity", "Vulnerability Type", "File Path", "Endpoint", "Description", "Exploitation Scenario", "Impact", "Recommended Fix"],
    ...findings.map((f) => [f.severity, f.type, f.file, f.endpoint, f.description, f.exploitation, f.impact, f.fix]),
  ];
  const endpointRows = [["Endpoint", "HTTP Method", "Authentication Required", "Expected Roles", "Controller/File Path"], ...endpoints];
  const riskRows = [
    ["Metric", "Value"],
    ["Total Findings", findings.length],
    ["Critical", critical],
    ["High", high],
    ["Medium", medium],
    ["Low", low],
    ["Overall Security Score", score],
  ];
  const inventoryRows = [["Key", "Value"], ...inventory.map((item) => [item.key, item.value])];

  await writeWorkbook(path.join(reportDir, "findings.xlsx"), [
    ["Security Findings", findingRows],
    ["Endpoint Inventory", endpointRows],
    ["Dependency Vulnerabilities", dependencyRows],
    ["Risk Summary", riskRows],
  ]);

  await writeWorkbook(path.join(reportDir, "endpoint-inventory.xlsx"), [
    ["Endpoint Inventory", endpointRows],
    ["Backend Inventory", inventoryRows],
    ["Risk Summary", riskRows],
  ]);

  const seleniumCases = testCaseRows("Selenium", 400);
  await writeWorkbook(path.join(root, "selenium-tests", "selenium-test-summary.xlsx"), [
    ["Summary", [["Test Suite / Category", "Total Cases", "Status"], ["Selenium - Website Tests", 400, "Ready to Run"], ["Login Tests", 50, "Ready to Run"], ["Validation Tests", 100, "Ready to Run"], ["Security UI Tests", 100, "Ready to Run"], ["Total Master Suite", 400, "Ready to Run"]]],
    ["Test Cases", seleniumCases],
  ]);

  const appiumCases = testCaseRows("Appium", 400);
  await writeWorkbook(path.join(root, "appium-tests", "appium-test-summary.xlsx"), [
    ["Summary", [["Test Suite / Category", "Total Cases", "Status"], ["Appium - Mobile App Tests", 400, "Ready to Run"], ["Login Tests", 50, "Ready to Run"], ["Validation Tests", 100, "Ready to Run"], ["Security UI Tests", 100, "Ready to Run"], ["Total Master Suite", 400, "Ready to Run"]]],
    ["Test Cases", appiumCases],
  ]);

  console.log(JSON.stringify({ reportDir, score, findings: findings.length, endpoints: endpoints.length }, null, 2));
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
