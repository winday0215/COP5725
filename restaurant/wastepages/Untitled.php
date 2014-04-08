CREATE VIEW RLIST AS
select r.rid, r.rname, r.zipcode, r.street, r.city, r.state, r.pricerange,
SDO_GEOM.SDO_DISTANCE(z1.GEO, z2.GEO, 0.5,'unit=mile') distance
FROM zipcode z1, zipcode z2, restaurant r
Where r.zipcode=z1.zip AND z2.zip = 32611 AND
SDO_WITHIN_DISTANCE(z1.GEO, z2.GEO, 'distance=10 unit=mile')='TRUE'
order by distance ASC;

select * FROM Rlist;

SELECT r.rname, r.distance, avg(ra.rating) as rating
FROM rlist r, rates ra
Where R.rid=ra.rid
GROUP BY r.rname, r.distance
ORDER BY r.distance ASC;