const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore

    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('29E4DBFBF4EA89EEDD8E8AF12C283AF5BF7C161A09AB19C91FE13435', './assets/base.ts')
    .addEntry('6226857A03360EE39D73C4915774DBFFBBF790DD2E71454CEC6F6CCD', './assets/base.sass')
    .addEntry('2263B472694502C71D809B1A2455848735913AD75EEEC2C5CDE905C3', './assets/base_mobile.sass')

    .addEntry('registro_css', './assets/registro/registro.css')
    .addEntry('registro_js', './assets/registro/registro.js')

    .addEntry('login_css', './assets/login/login.css')
    .addEntry('login_js', './assets/login/login.js')

    .addEntry('552AA95F47B6D2FA4ED712D68ED58983852CE0C7224B804CF3D1656D7D38B524', './assets/privado/conta/logado/painel.js')
    .addEntry('privado_conta_logado_painel_css', './assets/privado/conta/logado/painel.css')

    .addEntry('0EEB595B99A1E10E75D518CD237AD4E6B624AFF66FF0D0AE853D27FE', './assets/privado/conta/logado/editarperfil/editarperfil.js')
    .addEntry('409FA22CE8C2788ED56012D1F9A736C730DB2C0DA9827607DF53C1894B7B4767F1264ADAD8473C1377427A853B0FEADB', './assets/privado/conta/logado/finalizandoinfo/finalizandoinfo.js')
    
    .addEntry('309A9EDD7751DED9657D53881A831FD825A8CC651821CE90B84EC7E5', './assets/publico/home/home.sass')
    .addEntry('9C8FF948DB629C22507F0D68DD22C877932084A31F706E7B1FE470F3', './assets/publico/home/home.ts')
    .addEntry('F4273B66135294FBEE17F7331D048618CA68F28A5BE3515DC9FCA384E0FABAB7', './assets/publico/home/home_mobile.sass')

    .splitEntryChunks()
    .enableStimulusBridge('./assets/controllers.json')
    .enableSingleRuntimeChunk()
    .configureDevServerOptions((options) => {
        options.watchFiles = ['templates/**/*.twig'];
        options.hot = true;
        options.liveReload = true;
    })
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .enablePostCssLoader()
    .enableTypeScriptLoader()
;

module.exports = Encore.getWebpackConfig();
