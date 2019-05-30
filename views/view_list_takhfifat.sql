SELECT
 m1.id,
 m1.id_p1,
 m2.name1 AS name1,
 m1.id_p2,
 m3.name1 AS name2,
 m2.valint1 AS valint1,
 m1.valint1 AS valint2,
 m2.date1,
 m2.date2
FROM tcoding AS m1
INNER JOIN tcoding AS m2 ON m1.id_p1 = m2.id AND m2.deleted = 0 AND m2.id_noe = 4
INNER JOIN tcoding AS m3 ON m1.id_p2 = m3.id AND m3.deleted = 0 AND m3.id_noe = 2
WHERE m1.deleted = 0 AND m1.id_noe = 5