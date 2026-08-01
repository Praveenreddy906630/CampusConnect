import http from "k6/http";
import { check, sleep } from "k6";
import { Rate, Trend } from "k6/metrics";

export const options = {
  vus: Number(__ENV.VUS || 100),
  duration: __ENV.DURATION || "1m",
  thresholds: {
    http_req_failed: ["rate<0.05"],
    http_req_duration: ["p(95)<1500", "avg<500"],
  },
};

const BASE_URL = __ENV.BASE_URL || "http://127.0.0.1:8000";
const responseTrend = new Trend("campusconnect_response_time");
const successRate = new Rate("campusconnect_success_rate");

export default function () {
  const pages = ["/", "/events", "/coordinators", "/contact", "/login"];
  const path = pages[Math.floor(Math.random() * pages.length)];
  const response = http.get(`${BASE_URL}${path}`, {
    tags: { endpoint: path },
  });

  const ok = check(response, {
    "status is 2xx or 3xx": (res) => res.status >= 200 && res.status < 400,
    "response time below 1.5s": (res) => res.timings.duration < 1500,
  });
  successRate.add(ok);
  responseTrend.add(response.timings.duration);
  sleep(1);
}
