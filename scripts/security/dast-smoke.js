import http from "node:http";
import https from "node:https";

const baseUrl = process.env.API_BASE_URL || process.env.BASE_URL;
const endpoints = ["/", "/login", "/events", "/coordinators", "/admin/dashboard"];

function request(url) {
  return new Promise((resolve) => {
    const client = url.startsWith("https:") ? https : http;
    const req = client.get(url, { timeout: 5000 }, (res) => {
      res.resume();
      resolve({
        url,
        status: res.statusCode,
        headers: res.headers,
      });
    });
    req.on("timeout", () => {
      req.destroy();
      resolve({ url, status: "timeout", headers: {} });
    });
    req.on("error", (error) => resolve({ url, status: "error", error: error.message, headers: {} }));
  });
}

if (!baseUrl) {
  console.log("No API_BASE_URL or BASE_URL supplied. Skipping live DAST smoke checks.");
  process.exit(0);
}

const results = [];
for (const endpoint of endpoints) {
  const target = new URL(endpoint, baseUrl).toString();
  results.push(await request(target));
}

console.table(results.map((result) => ({
  url: result.url,
  status: result.status,
  csp: result.headers["content-security-policy"] ? "present" : "missing",
  xFrameOptions: result.headers["x-frame-options"] ? "present" : "missing",
  cors: result.headers["access-control-allow-origin"] || "",
})));

const weakHeaders = results.filter((result) =>
  typeof result.status === "number" &&
  result.status < 500 &&
  (!result.headers["content-security-policy"] || !result.headers["x-frame-options"])
);

if (weakHeaders.length > 0) {
  console.warn("DAST smoke warning: one or more responses are missing CSP or X-Frame-Options.");
}
