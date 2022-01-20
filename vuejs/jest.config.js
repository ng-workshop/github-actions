module.exports = {
  preset: '@vue/cli-plugin-unit-jest',
  collectCoverage: true,
  collectCoverageFrom: [
    "**/*.{js,jsx,vue}",
    "!**/coverage/**",
    "!**/node_modules/**",
    "!**/src/plugins/**",
    "!**/src/router/**",
    "!**/src/store/index.js",
    "!**/src/main.js",
    "!**/tests/**",
    "!**/babel.config.js",
    "!**/jest.config.js",
    "!**/vue.config.js",
  ],
  coverageDirectory: 'coverage/jest',
  coveragePathIgnorePatterns: [],
  coverageReporters: ['clover', 'lcov', 'text']
}
