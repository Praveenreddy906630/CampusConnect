import { until, By } from "selenium-webdriver";

export default class BasePage {
  constructor(driver) {
    this.driver = driver;
  }

  async navigate(url) {
    await this.driver.get(url);
  }

  async waitForPageLoad() {
    await this.driver.wait(async () => {
      const state = await this.driver.executeScript("return document.readyState");
      return state === "complete" || state === "interactive";
    }, 10000);
  }

  async find(locator) {
    return this.driver.findElement(locator);
  }

  async click(locator) {
    const el = await this.driver.wait(until.elementLocated(locator), 10000);
    await this.driver.wait(until.elementIsVisible(el), 10000);
    await el.click();
  }

  async type(locator, text) {
    const el = await this.driver.wait(until.elementLocated(locator), 10000);
    await this.driver.wait(until.elementIsVisible(el), 10000);
    await el.clear();
    await el.sendKeys(text);
  }
}
