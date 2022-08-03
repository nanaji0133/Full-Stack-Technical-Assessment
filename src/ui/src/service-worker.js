self.__precacheManifest = [].concat(self.__precacheManifest || []);
workbox.precaching.suppressWarnings();
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});

workbox.routing.registerNavigationRoute('/');
workbox.routing.registerNavigationRoute('/login');
workbox.routing.registerNavigationRoute('/signup');

// install new service worker when ok, then reload page.
self.addEventListener("message", msg => {
    if (msg.data.action == 'skipWaiting') {
        self.skipWaiting()
    }
})