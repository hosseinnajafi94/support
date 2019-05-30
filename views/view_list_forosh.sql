SELECT
	m1.id,
	m1.id_p1,
	m1.valint1,
	m1.id_user1,
	m1.id_user2,
	m1.date1,
	m1.date2,
	m1.valint2,
	m1.valint3,
	m1.name1,
	m1.valint4,
	m1.valint5,
	m1.valint6,
	m1.valint7,
	m1.valint8,
	m1.valint9
FROM
tcoding AS m1
WHERE m1.deleted = 0 AND m1.id_noe = 3