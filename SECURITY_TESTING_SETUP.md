# CampusConnect Security and E2E Testing Setup

## Security Review

Generated reports are in `Vulnerability Test Results/`:

- `security-review.md`
- `executive-summary.md`
- `dependency-report.md`
- `endpoint-inventory.xlsx`
- `findings.xlsx`

Run the report generator locally:

```bash
node scripts/security/generate-security-artifacts.mjs
```

Run non-destructive DAST smoke checks only when a test URL exists:

```bash
BASE_URL=http://127.0.0.1:8000 node scripts/security/dast-smoke.js
```

The GitHub Actions workflow is at `.github/workflows/security-review.yml`. It detects the backend stack, runs SAST/dependency/security scans, uploads reports, writes a GitHub Action summary, and fails only when Critical findings are present.

## Selenium Website Tests

```bash
cd selenium-tests
npm install
BASE_URL=http://127.0.0.1:8000 TEST_EMAIL=student@example.com TEST_PASSWORD='Password123!' npm run test:login
```

The Excel summary with 400 website E2E cases is `selenium-tests/selenium-test-summary.xlsx`.

## Appium Mobile Tests

```bash
cd appium-tests
npm install
APP_PATH=/absolute/path/to/app.apk TEST_EMAIL=student@example.com TEST_PASSWORD='Password123!' npm run test:app
```

For an installed Android app, use:

```bash
APP_PACKAGE=com.example.campusconnect APP_ACTIVITY=.MainActivity npm run test:app
```

The Excel summary with 400 mobile E2E cases is `appium-tests/appium-test-summary.xlsx`.

## Baseline Load Testing

Install k6, then run:

```bash
BASE_URL=http://127.0.0.1:8000 VUS=100 DURATION=1m k6 run load-tests/baseline-load-test.js
```

The load test reports requests per second, response-time metrics, failed request rate, and threshold pass/fail status.
