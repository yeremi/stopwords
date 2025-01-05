module.exports = {
  "branches": [
    "main",
    "next",
    {
      "name": "beta",
      "prerelease": true
    },
    {
      "name": "alpha",
      "prerelease": true
    }
  ],
  "plugins": [
    "@semantic-release/commit-analyzer",
    "@semantic-release/release-notes-generator",
    "@semantic-release/changelog",
    ["@semantic-release/npm", {
      "tarballDir": "release",
      "npmPublish": false
    }],
    "@semantic-release/exec",
    "@semantic-release/github",
    ["@semantic-release/git", {
      "assets": ["CHANGELOG.md", "package-lock.json", "package.json", "composer.json"],
      "message": "chore(release): \${nextRelease.version} [skip ci]\n\n\${nextRelease.notes}"
    }]
  ],
  "preset": "angular",
  "tagFormat": "${version}"
}