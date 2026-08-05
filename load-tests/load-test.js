import http from 'k6/http';
import { check, sleep } from 'k6';

// 1. Configure the Baseline Load Test Criteria
export const options = {
  vus: 100,         // 100 concurrent virtual users
  duration: '1m',   // Running continuously for 1 minute
  thresholds: {
    // Assertions based on admin requirements
    http_req_duration: ['avg<250', 'max<1500'], // Average: < 250ms, Slowest: < 1.5s
    http_reqs: ['rate>=120'],                   // Target Requests Per Second (RPS)
  },
};

// 2. Define the Test Execution Flow
export default function () {
  // Uses the live GitHub Pages URL
  const TARGET_URL = __ENV.BASE_URL || 'https://praveenreddy906630.github.io/CampusConnect/';

  const res = http.get(TARGET_URL);

  // 3. Verify Response Status and Timing
  check(res, {
    'is status 200 OK': (r) => r.status === 200,
    'response time is within acceptable limits': (r) => r.timings.duration < 1500,
  });

  // Sleep briefly to simulate realistic pacing between user requests
  sleep(0.1);
}
