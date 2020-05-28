module.exports = {
    // proxy API requests to Valet during development
    devServer: {
        proxy: "http://lab.cbble.local"
    },

    // output built static files to Laravel's public dir.
    // note the "build" script in package.json needs to be modified as well.
    outputDir: "../../../public/assets/lab",

    publicPath: process.env.NODE_ENV === "production" ? "/assets/lab/" : "/lab",

    // modify the location of the generated HTML file.
    // make sure to do this only in production.
    indexPath:
        process.env.NODE_ENV === "production"
            ? "../../../resources/views/layouts/lab.blade.php"
            : "index.html"
};
