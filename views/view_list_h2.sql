SELECT m1.id, m1.name1, m1.id_user1,
IFNULL(SUM(m2.bed), 0) - IFNULL(SUM(m2.bes), 0) AS valint1
FROM tcoding AS m1
INNER JOIN hesabha AS m2 ON (m2.id_p1 = m1.id AND m2.id_p2 IS NULL AND m2.id_user1 = m1.id_user1) OR (m2.id_p2 = m1.id AND m2.id_p1 = m1.id_p1 AND m2.id_user1 = m1.id_user1)
WHERE m1.id_noe IN(5, 7) AND m1.deleted = 0
GROUP BY m1.id
ORDER BY m1.id DESC