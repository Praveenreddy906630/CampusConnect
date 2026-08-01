# Baseline Load Test

Run a non-destructive 100 virtual user, 1 minute baseline test:

```bash
BASE_URL=http://127.0.0.1:8000 k6 run load-tests/baseline-load-test.js
```

Expected output includes requests per second, response time percentiles, failed request rate, and threshold status.
