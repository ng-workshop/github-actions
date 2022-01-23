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
    "!**/src/views/**",
    "!**/src/main.js",
    "!**/tests/**",
    "!**/babel.config.js",
    "!**/jest.config.js",
    "!**/vue.config.js",
  ],
  coverageDirectory: "reports/jest",
  coveragePathIgnorePatterns: [],
  coverageReporters: [
    "lcov",
    "text"
  ],
  reporters: [
    "default",
    ["jest-junit", { suiteName: "jest tests" }],
  ]
}
