# Usage

```
php ./distance.php
```
Output
```
...
double(132.10064834711)
```


## Redis

```
cat redis-data | redis-cli
```

Output
```
(integer) 0
(integer) 0
"132.1008"
```

## Note
The algorith is extracted from redis source code - https://github.com/antirez/redis/blob/b2cd9fcab6122ccbf8b08f71f59a0af01931083b/src/geohash_helper.c#L211

It is worth note that - https://redis.io/commands/geoadd#what-earth-model-does-it-use:
>It just assumes that the Earth is a sphere, since the used distance formula is the Haversine formula. This formula is only an approximation when applied to the Earth, which is not a perfect sphere. The introduced errors are not an issue when used in the context of social network sites that need to query by radius and most other applications. However in the worst case the error may be up to 0.5%, so you may want to consider other systems for error-critical applications.