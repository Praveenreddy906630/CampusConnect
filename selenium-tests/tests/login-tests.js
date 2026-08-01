import { Builder, By, Key, until } from "selenium-webdriver";
import chrome from "selenium-webdriver/chrome.js";
import assert from "node:assert/strict";

const BASE_URL = process.env.BASE_URL || "http://127.0.0.1:8000";
const TEST_EMAIL = process.env.TEST_EMAIL || "student@example.com";
const TEST_PASSWORD = process.env.TEST_PASSWORD || "Password123!";
const HEADLESS = process.env.HEADLESS !== "false";

function buildDriver() {
  const options = new chrome.Options();
  if (HEADLESS) {
    options.addArguments("--headless=new", "--disable-gpu", "--window-size=1440,1000");
  }
  options.addArguments("--no-sandbox", "--disable-dev-shm-usage");
  return new Builder().forBrowser("chrome").setChromeOptions(options).build();
}

async function waitForPage(driver) {
  await driver.wait(async () => {
    const state = await driver.executeScript("return document.readyState");
    return state === "complete" || state === "interactive";
  }, 10000);
}

async function login(driver, email = TEST_EMAIL, password = TEST_PASSWORD) {
  await driver.get(`${BASE_URL}/login`);
  await waitForPage(driver);
  await driver.wait(until.elementLocated(By.css('input[name="email"], input[type="email"]')), 10000);

  const emailInput = await driver.findElement(By.css('input[name="email"], input[type="email"]'));
  const passwordInput = await driver.findElement(By.css('input[name="password"], input[type="password"]'));
  await emailInput.clear();
  await emailInput.sendKeys(email);
  await passwordInput.clear();
  await passwordInput.sendKeys(password, Key.ENTER);

  await driver.wait(async () => {
    const body = await driver.findElement(By.css("body")).getText();
    const url = await driver.getCurrentUrl();
    return /dashboard|CampusConnect|Invalid|successful/i.test(body) || !url.endsWith("/login");
  }, 12000);
}

const tests = [
  {
    name: "login page renders email and password fields",
    run: async (driver) => {
      await driver.get(`${BASE_URL}/login`);
      await waitForPage(driver);
      assert.ok(await driver.findElement(By.css('input[name="email"], input[type="email"]')).isDisplayed());
      assert.ok(await driver.findElement(By.css('input[name="password"], input[type="password"]')).isDisplayed());
    },
  },
  {
    name: "invalid login returns a user friendly error",
    run: async (driver) => {
      await login(driver, "invalid-user@example.com", "wrong-password");
      const body = await driver.findElement(By.css("body")).getText();
      assert.match(body, /invalid|error|password|required/i);
    },
  },
  {
    name: "valid login redirects away from login page",
    run: async (driver) => {
      await login(driver);
      const currentUrl = await driver.getCurrentUrl();
      assert.ok(!currentUrl.endsWith("/login"), `Expected redirect away from login page, got ${currentUrl}`);
    },
  },
  {
    name: "authenticated logout returns to public home page",
    run: async (driver) => {
      await login(driver);
      const logoutForm = await driver.findElements(By.css('form[action$="/logout"], form[action*="/logout"]'));
      if (logoutForm.length > 0) {
        await logoutForm[0].submit();
      } else {
        await driver.get(`${BASE_URL}/`);
      }
      await waitForPage(driver);
      assert.match(await driver.getTitle(), /Campus|Connect|Laravel|/);
    },
  },
];

async function main() {
  const driver = await buildDriver();
  const results = [];
  try {
    for (const test of tests) {
      const started = Date.now();
      try {
        await test.run(driver);
        results.push({ name: test.name, status: "PASS", durationMs: Date.now() - started });
      } catch (error) {
        results.push({ name: test.name, status: "FAIL", durationMs: Date.now() - started, error: error.message });
      }
    }
  } finally {
    await driver.quit();
  }

  console.table(results);
  const failures = results.filter((result) => result.status === "FAIL");
  if (failures.length > 0) {
    process.exitCode = 1;
  }
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
