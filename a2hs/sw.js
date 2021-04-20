self.addEventListener('install', (e) => {
  e.waitUntil(
    caches.open('fox-store').then((cache) => cache.addAll([
      '/addhomescreenss/a2hs/',
      '/addhomescreenss/a2hs/index.html',
      '/addhomescreenss/a2hs/index.js',
      '/addhomescreenss/a2hs/style.css',
      '/addhomescreenss/a2hs/images/fox1.jpg',
      '/addhomescreenss/a2hs/images/fox2.jpg',
      '/addhomescreenss/a2hs/images/fox3.jpg',
      '/addhomescreenss/a2hs/images/fox4.jpg',
    ])),
  );
});

self.addEventListener('fetch', (e) => {
  console.log(e.request.url);
  e.respondWith(
    caches.match(e.request).then((response) => response || fetch(e.request)),
  );
});
