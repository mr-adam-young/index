module.exports = {
    branches: [
        { name: 'main' },                    // Stable releases for general use
        { name: 'next', prerelease: true },   // Pre-releases (e.g., 1.1.0-next.1)
        { name: 'hessiron-stable' },          // Independent stable branch for the client
      ],
    plugins: [
      '@semantic-release/commit-analyzer',
      '@semantic-release/release-notes-generator',
      '@semantic-release/changelog',
      '@semantic-release/github',
      [
        '@semantic-release/git',
        {
          assets: ['CHANGELOG.md'],
          message: 'chore(release): ${nextRelease.version} [skip ci]\n\n${nextRelease.notes}',
        },
      ],
    ],
  };