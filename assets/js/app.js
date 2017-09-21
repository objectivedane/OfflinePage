/**
 * Created by frankle on 19/09/17.
 */
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/wp-content/plugins/OfflinePage/assets/js/service.js', {
        scope: '/'
    }).then(function(reg) {
        console.log(reg.scope, 'register');
        console.log('Service worker change, registered the service worker');
    })
        .catch(function(e){
            console.error('Service worker failed: ' + e);
        });
}


