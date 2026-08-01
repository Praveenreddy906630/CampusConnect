#!/usr/bin/env bash
set -euo pipefail

framework="unknown"
language="unknown"
package_manager="unknown"

if [[ -f composer.json ]] && grep -qi '"laravel/framework"' composer.json; then
  framework="Laravel"
  language="PHP"
  package_manager="composer"
elif [[ -f package.json ]] && grep -qi '"express"' package.json; then
  framework="Express"
  language="Node.js"
  package_manager="npm"
elif [[ -f requirements.txt ]] && grep -Eqi 'django|fastapi|flask' requirements.txt; then
  language="Python"
  package_manager="pip"
  if grep -qi 'django' requirements.txt; then framework="Django"; fi
  if grep -qi 'fastapi' requirements.txt; then framework="FastAPI"; fi
  if grep -qi 'flask' requirements.txt; then framework="Flask"; fi
elif [[ -f pom.xml ]]; then
  framework="Java"
  language="Java"
  package_manager="maven"
elif [[ -f go.mod ]]; then
  framework="Go"
  language="Go"
  package_manager="go"
fi

mkdir -p "Vulnerability Test Results"
{
  echo "framework=${framework}"
  echo "language=${language}"
  echo "package_manager=${package_manager}"
} | tee "Vulnerability Test Results/stack.env"
