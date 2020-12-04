var NAMA_CACHE = '3ps-cache';

var daftar_file =
[
    '/offline/modas/modas.js',
]
importScripts('/offline/idb.js');
importScripts('/offline/modas/modas.js');

self.addEventListener('install', function(event)
{
    console.log('instal ya');
    event.waitUntil(
        caches.open(nama_cache)
        .then(function(cache)
        {
            console.log('melakukan caching');
            return cache.addAll(daftar_file);
        })
    );
});


self.addEventListener('fetch',function(event)
{
    console.log("masuk ke fetch listener");
    event.respondWith(
        caches.match(event.request)
        .then( (response)=>
        {
            if (response)
            {
                return response;
            }
                    
            return fetch(event.request).catch(function()
            {
                return caches.match('/offline.txt');
            });
        })
    )
});

self.addEventListener('sync',function(event)
{
    console.log("masuk ke sync listener");

    if (event.tag==='sync-new-modas')
	{
        idb_pos_trx.getAll().then (function(all_row)
        {
            for (var pos_trx of all_row)
            {
                kirimData(pos_trx);
            }
        });
    }
});
