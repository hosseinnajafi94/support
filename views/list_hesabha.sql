SELECT m1.id, m1.id_user1, m1.name1, valint1, valint2, valint3
FROM tcoding AS m1
WHERE (
		m1.deleted = 0
	AND m1.id_noe  = 9
	AND m1.id_p2   = 4
	AND m1.id_p1   = 18
) OR (
		m1.deleted = 0
	AND m1.id_noe  = 9
	AND m1.id_p2   = 4
	AND m1.id_p1 IN (
		SELECT m2.id
		FROM tcoding AS m2
		WHERE m2.id_p1 = 18 AND m2.id_noe = 7 AND m2.deleted = 0
	)
)




SELECT m1.id, m1.id_user1, m1.name1, valint1, valint2, valint3
FROM tcoding AS m1
WHERE (
		m1.deleted = 0
	AND m1.id_noe  = 9
	AND m1.id_p2   = 3
	AND m1.id_p1   = 18
) OR (
		m1.deleted = 0
	AND m1.id_noe  = 9
	AND m1.id_p2   = 3
	AND m1.id_p1 IN (
		SELECT m2.id
		FROM tcoding AS m2
		WHERE m2.id_p1 = 18 AND m2.id_noe = 7 AND m2.deleted = 0
	)
)