SELECT
m1.id,
m1.id_p1,
m1.id_p2,
m1.date1,
m1.date2,
m1.valint1
FROM
tcoding AS m1
WHERE m1.deleted = 0 AND m1.id_noe = 7