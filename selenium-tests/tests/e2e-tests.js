import { Builder, By, Key, until } from "selenium-webdriver";
import chrome from "selenium-webdriver/chrome.js";
import assert from "node:assert/strict";
import fs from "node:fs";
import path from "node:path";
import ExcelJS from "exceljs";
import HomePage from "../pages/HomePage.js";

const BASE_URL = process.env.BASE_URL || "http://127.0.0.1:8000";
const HEADLESS = process.env.HEADLESS !== "false";

// Directories
const RESULTS_DIR = path.join(process.cwd(), "..", "Test Results");
const EXCEL_DIR = path.join(RESULTS_DIR, "Excel");
const HTML_DIR = path.join(RESULTS_DIR, "HTML");
const SCREENSHOTS_DIR = path.join(RESULTS_DIR, "Screenshots");
const LOGS_DIR = path.join(RESULTS_DIR, "Logs");
const SUMMARY_DIR = path.join(RESULTS_DIR, "Summary");

[RESULTS_DIR, EXCEL_DIR, HTML_DIR, SCREENSHOTS_DIR, LOGS_DIR, SUMMARY_DIR].forEach(dir => {
  if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
});

function buildDriver() {
  const options = new chrome.Options();
  if (HEADLESS) {
    options.addArguments("--headless=new", "--disable-gpu", "--window-size=1440,1000");
  }
  options.addArguments("--no-sandbox", "--disable-dev-shm-usage");
  return new Builder().forBrowser("chrome").setChromeOptions(options).build();
}

async function generateExcel(results) {
  const workbook = new ExcelJS.Workbook();
  const sheet = workbook.addWorksheet("Test Results");
  sheet.columns = [
    { header: "Test Name", key: "name", width: 45 },
    { header: "Status", key: "status", width: 15 },
    { header: "Duration (ms)", key: "duration", width: 15 },
    { header: "Error", key: "error", width: 50 },
    { header: "Screenshot", key: "screenshot", width: 40 },
  ];
  results.forEach(r => {
    sheet.addRow({
      name: r.name,
      status: r.status,
      duration: r.durationMs,
      error: r.error || "",
      screenshot: r.screenshot || ""
    });
  });
  const file = path.join(EXCEL_DIR, "Automation_Test_Report.xlsx");
  await workbook.xlsx.writeFile(file);
}

function generateHTML(results, total, passed, failed, passRate) {
  const rows = results.map(r => `
    <tr class="${r.status === 'PASS' ? 'bg-green-50' : 'bg-red-50'} border-b">
      <td class="px-4 py-3">${r.name}</td>
      <td class="px-4 py-3 font-semibold ${r.status === 'PASS' ? 'text-green-600' : 'text-red-600'}">${r.status}</td>
      <td class="px-4 py-3">${r.durationMs}ms</td>
      <td class="px-4 py-3 text-red-500 text-sm max-w-xs truncate" title="${r.error || ''}">${r.error || ''}</td>
      <td class="px-4 py-3 text-sm text-blue-600 hover:underline">${r.screenshot ? `<a href="../Screenshots/${r.screenshot}" target="_blank">View Screenshot</a>` : ''}</td>
    </tr>
  `).join('');

  const html = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Live E2E Execution Report</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8 font-sans">
  <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <div class="flex items-center justify-between mb-8 pb-4 border-b">
      <h1 class="text-3xl font-bold text-gray-800">Live E2E Test Execution Report</h1>
      <span class="text-gray-500 text-sm">Target: ${BASE_URL}</span>
    </div>
    
    <div class="grid grid-cols-4 gap-6 mb-10">
      <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 text-center shadow-sm">
        <div class="text-sm text-blue-500 font-medium uppercase tracking-wider mb-1">Total Tests</div>
        <div class="text-4xl font-bold text-blue-700">${total}</div>
      </div>
      <div class="bg-green-50 p-6 rounded-lg border border-green-100 text-center shadow-sm">
        <div class="text-sm text-green-500 font-medium uppercase tracking-wider mb-1">Passed</div>
        <div class="text-4xl font-bold text-green-700">${passed}</div>
      </div>
      <div class="bg-red-50 p-6 rounded-lg border border-red-100 text-center shadow-sm">
        <div class="text-sm text-red-500 font-medium uppercase tracking-wider mb-1">Failed</div>
        <div class="text-4xl font-bold text-red-700">${failed}</div>
      </div>
      <div class="bg-purple-50 p-6 rounded-lg border border-purple-100 text-center shadow-sm">
        <div class="text-sm text-purple-500 font-medium uppercase tracking-wider mb-1">Pass Rate</div>
        <div class="text-4xl font-bold text-purple-700">${passRate}%</div>
      </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700 uppercase text-sm tracking-wider">
            <th class="px-4 py-4 font-semibold">Test Name</th>
            <th class="px-4 py-4 font-semibold">Status</th>
            <th class="px-4 py-4 font-semibold">Duration</th>
            <th class="px-4 py-4 font-semibold">Error</th>
            <th class="px-4 py-4 font-semibold">Screenshot</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          ${rows}
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>`;
  fs.writeFileSync(path.join(HTML_DIR, "execution-report.html"), html);
}

function generateMarkdown(results, total, passed, failed, passRate) {
  const failedTests = results.filter(r => r.status === 'FAIL').map(r => `- **${r.name}**: ${r.error}`).join('\n');
  const md = `# Live GitHub Pages E2E Test Summary

**Deployment URL:** ${BASE_URL}

**Total Tests:** ${total}  
**Passed:** ${passed}  
**Failed:** ${failed}  
**Skipped:** 0  
**Pass Percentage:** ${passRate}%  

${failed > 0 ? `**Failed Tests:**\n${failedTests}` : '**All tests passed successfully!**'}
`;
  fs.writeFileSync(path.join(SUMMARY_DIR, "summary.md"), md);
}

const tests = [
  {
    name: "Home Page loads and displays brand logo",
    run: async (driver, homePage) => {
      await homePage.navigate(BASE_URL);
      await homePage.waitForPageLoad();
      assert.ok(await homePage.isBrandVisible(), "Brand logo should be visible");
    },
  },
  {
    name: "Hero section heading is correct",
    run: async (driver, homePage) => {
      await homePage.navigate(BASE_URL);
      await homePage.waitForPageLoad();
      const heading = await homePage.getHeroHeadingText();
      assert.match(heading, /Manage Events/i, "Heading should mention Manage Events");
    },
  },
  {
    name: "CTA Button is present",
    run: async (driver, homePage) => {
      await homePage.navigate(BASE_URL);
      await homePage.waitForPageLoad();
      assert.ok(await homePage.isCtaButtonVisible(), "CTA Button should be visible");
    },
  },
  {
    name: "Hero Image renders correctly",
    run: async (driver, homePage) => {
      await homePage.navigate(BASE_URL);
      await homePage.waitForPageLoad();
      assert.ok(await homePage.isHeroImageVisible(), "Hero image should be visible");
    },
  }
];

async function main() {
  const driver = await buildDriver();
  const homePage = new HomePage(driver);
  const results = [];
  try {
    for (const test of tests) {
      const started = Date.now();
      let screenshotName = '';
      try {
        await test.run(driver, homePage);
        screenshotName = `${test.name.replace(/\s+/g, "_")}_PASS.png`;
        const image = await driver.takeScreenshot();
        fs.writeFileSync(path.join(SCREENSHOTS_DIR, screenshotName), image, 'base64');
        results.push({ name: test.name, status: "PASS", durationMs: Date.now() - started, screenshot: screenshotName });
      } catch (error) {
        screenshotName = `${test.name.replace(/\s+/g, "_")}_FAIL.png`;
        const image = await driver.takeScreenshot();
        fs.writeFileSync(path.join(SCREENSHOTS_DIR, screenshotName), image, 'base64');
        results.push({ name: test.name, status: "FAIL", durationMs: Date.now() - started, error: error.message, screenshot: screenshotName });
      }
    }
  } finally {
    await driver.quit();
  }

  const total = results.length;
  const passed = results.filter(r => r.status === "PASS").length;
  const failed = total - passed;
  const passRate = total === 0 ? 0 : Math.round((passed / total) * 100);

  await generateExcel(results);
  generateHTML(results, total, passed, failed, passRate);
  generateMarkdown(results, total, passed, failed, passRate);

  console.table(results);
  if (failed > 0) {
    process.exitCode = 1;
  }
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
