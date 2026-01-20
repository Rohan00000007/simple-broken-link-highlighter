# Simple Broken Link Highlighter

## Features
- Scans external links on post save
- Detects 4xx/5xx/timeout via HEAD requests
- Stores broken links in post meta
- Ignore broken links per post
- Tools → Broken Links admin screen
- Search + bulk recheck (AJAX)
- Rate-limited requests

## Security
- Capability checks
- Nonce verification
- Escaped output

## Performance
- No cron jobs
- Scans only on save
- HEAD requests + micro sleep

## How to Test
1. Add invalid external link in a post
2. Save post
3. Check editor sidebar
4. Use Tools → Broken Links
