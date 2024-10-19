export default {
    /*
    branches: [
        // Main branch: Product releases in the 0.x range
        { name: 'main', range: '0.x', channel: 'latest', type: 'release'},
    
        // Hessiron-stable: Custom client releases with independent versions
        { name: 'hessiron-stable', range: '>=0.100.0 <1.0.0', channel: 'hessiron' }
      ],
    */
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