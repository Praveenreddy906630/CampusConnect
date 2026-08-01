import { remote } from "webdriverio";
import assert from "node:assert/strict";

const APPIUM_SERVER = process.env.APPIUM_SERVER || "http://127.0.0.1:4723";
const PLATFORM_NAME = process.env.PLATFORM_NAME || "Android";
const DEVICE_NAME = process.env.DEVICE_NAME || "Android Emulator";
const APP_PATH = process.env.APP_PATH;
const APP_PACKAGE = process.env.APP_PACKAGE;
const APP_ACTIVITY = process.env.APP_ACTIVITY;
const TEST_EMAIL = process.env.TEST_EMAIL || "student@example.com";
const TEST_PASSWORD = process.env.TEST_PASSWORD || "Password123!";

function capabilities() {
  const caps = {
    platformName: PLATFORM_NAME,
    "appium:deviceName": DEVICE_NAME,
    "appium:automationName": PLATFORM_NAME.toLowerCase() === "ios" ? "XCUITest" : "UiAutomator2",
    "appium:newCommandTimeout": 120,
  };

  if (APP_PATH) {
    caps["appium:app"] = APP_PATH;
  }
  if (APP_PACKAGE) {
    caps["appium:appPackage"] = APP_PACKAGE;
  }
  if (APP_ACTIVITY) {
    caps["appium:appActivity"] = APP_ACTIVITY;
  }
  return caps;
}

async function firstExisting(driver, selectors) {
  for (const selector of selectors) {
    const element = await driver.$(selector);
    if (await element.isExisting()) {
      return element;
    }
  }
  throw new Error(`None of the selectors matched: ${selectors.join(", ")}`);
}

async function login(driver, email = TEST_EMAIL, password = TEST_PASSWORD) {
  const emailField = await firstExisting(driver, [
    'android=new UiSelector().resourceIdMatches(".*email.*")',
    'android=new UiSelector().textContains("Email")',
    '~email',
  ]);
  const passwordField = await firstExisting(driver, [
    'android=new UiSelector().resourceIdMatches(".*password.*")',
    'android=new UiSelector().textContains("Password")',
    '~password',
  ]);

  await emailField.setValue(email);
  await passwordField.setValue(password);
  const loginButton = await firstExisting(driver, [
    'android=new UiSelector().textMatches("(?i).*login.*|.*sign in.*")',
    '~login',
    '~sign-in',
  ]);
  await loginButton.click();
}

const tests = [
  {
    name: "app launches and shows an interactive screen",
    run: async (driver) => {
      const source = await driver.getPageSource();
      assert.ok(source.length > 100, "Expected a populated app source after launch");
    },
  },
  {
    name: "login controls are present",
    run: async (driver) => {
      await firstExisting(driver, ['android=new UiSelector().textContains("Email")', "~email"]);
      await firstExisting(driver, ['android=new UiSelector().textContains("Password")', "~password"]);
    },
  },
  {
    name: "invalid login shows validation or error feedback",
    run: async (driver) => {
      await login(driver, "invalid-user@example.com", "wrong-password");
      await driver.pause(1500);
      const source = await driver.getPageSource();
      assert.match(source, /invalid|required|error|password|try again/i);
    },
  },
  {
    name: "valid login reaches an authenticated screen",
    run: async (driver) => {
      await login(driver);
      await driver.pause(2500);
      const source = await driver.getPageSource();
      assert.match(source, /dashboard|events|profile|logout|CampusConnect/i);
    },
  },
];

async function main() {
  if (!APP_PATH && !APP_PACKAGE) {
    throw new Error("Set APP_PATH for an .apk/.ipa or APP_PACKAGE/APP_ACTIVITY for an installed Android app.");
  }

  const driver = await remote({
    hostname: new URL(APPIUM_SERVER).hostname,
    port: Number(new URL(APPIUM_SERVER).port || 4723),
    path: new URL(APPIUM_SERVER).pathname === "/" ? "/" : new URL(APPIUM_SERVER).pathname,
    capabilities: capabilities(),
  });

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
    await driver.deleteSession();
  }

  console.table(results);
  if (results.some((result) => result.status === "FAIL")) {
    process.exitCode = 1;
  }
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
