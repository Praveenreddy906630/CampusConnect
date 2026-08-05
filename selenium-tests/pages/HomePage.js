import BasePage from "./BasePage.js";
import { By } from "selenium-webdriver";

export default class HomePage extends BasePage {
  constructor(driver) {
    super(driver);
    this.brandLogo = By.css('.brand .mark');
    this.heroHeading = By.css('.hero h1');
    this.ctaButton = By.css('.hero .button');
    this.heroImage = By.css('.hero-shot img');
  }

  async isBrandVisible() {
    const el = await this.find(this.brandLogo);
    return el.isDisplayed();
  }

  async getHeroHeadingText() {
    const el = await this.find(this.heroHeading);
    return el.getText();
  }

  async isCtaButtonVisible() {
    const el = await this.find(this.ctaButton);
    return el.isDisplayed();
  }

  async isHeroImageVisible() {
    const el = await this.find(this.heroImage);
    return el.isDisplayed();
  }
}
