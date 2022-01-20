module.exports = {
    devServer: {
        disableHostCheck: true,
    },
    css: {
        loaderOptions: {
            sass: {
                prependData: `
                  @import "@/assets/scss/custom.scss";
                `
            }
        }
    }
};
