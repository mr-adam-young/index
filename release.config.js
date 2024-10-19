export default {
    branches: [
        // Main branch: Primary product release in 0.x range
        { name: 'main', range: '0.x', type: 'release', channel: 'latest' },

        // Hessiron-stable: Custom client-specific release, also in 0.x range
        { name: 'hessiron-stable', range: '0.x', type: 'release', channel: 'hessiron' },

        // Pre-release branch for testing features
        { name: 'next', prerelease: true, channel: 'next', type: 'release' },

        // Feature branches with isolated pre-releases
        { name: 'feature/*', prerelease: true, channel: 'feature', type: 'release' },

        // Catch-all for other pre-release branches
        { name: '*', prerelease: true, channel: 'development', type: 'release' },
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