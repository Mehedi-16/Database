# MID QUESTIONS SOLVE
Here are the SQL queries to solve each question:

### **(i) Create a database and table, then insert tuples**
```sql
CREATE DATABASE HasanMamun;

USE HasanMamun;

CREATE TABLE department (
    dept_name VARCHAR(50) PRIMARY KEY,
    budget DECIMAL(10,2)
);

CREATE TABLE instructor (
    ID INT PRIMARY KEY,
    name VARCHAR(50),
    dept_name VARCHAR(50),
    salary DECIMAL(10,2),
    FOREIGN KEY (dept_name) REFERENCES department(dept_name)
);

INSERT INTO department (dept_name, budget) VALUES
('Computer Science', 500000),
('Mathematics', 300000),
('Physics', 350000),
('Astronomy', 200000);

INSERT INTO instructor (ID, name, dept_name, salary) VALUES
(1, 'Alice', 'Computer Science', 85000),
(2, 'Bob', 'Mathematics', 92000),
(3, 'Charlie', 'Physics', 110000),
(4, 'David', 'Computer Science', 89000);
```

---

### **(ii) Find department names with a budget higher than Astronomy**
```sql
SELECT dept_name
FROM department
WHERE budget > (SELECT budget FROM department WHERE dept_name = 'Astronomy')
ORDER BY dept_name;
```

---

### **(iii) Find instructors in the Computer Science department with a salary less than 90,000**
```sql
SELECT name
FROM instructor
WHERE dept_name = 'Computer Science' AND salary < 90000;
```

---

### **(iv) Find the number of instructors in each department in the 2010 semester**
(Assuming an additional `teaches` table exists)
```sql
CREATE TABLE teaches (
    ID INT,
    course_id VARCHAR(10),
    semester VARCHAR(10),
    year INT,
    FOREIGN KEY (ID) REFERENCES instructor(ID)
);

INSERT INTO teaches (ID, course_id, semester, year) VALUES
(1, 'CSE101', 'Spring', 2010),
(2, 'MTH201', 'Fall', 2010),
(3, 'PHY301', 'Spring', 2010),
(4, 'CSE102', 'Fall', 2010);

SELECT d.dept_name, COUNT(t.ID) AS num_instructors
FROM instructor i
JOIN teaches t ON i.ID = t.ID
JOIN department d ON i.dept_name = d.dept_name
WHERE t.year = 2010
GROUP BY d.dept_name;
```

---

### **(v) Increase salaries accordingly**
```sql
UPDATE instructor
SET salary = salary * 1.0303
WHERE salary > 100000;

UPDATE instructor
SET salary = salary * 1.045
WHERE salary <= 100000;
```

Let me know if you need any modifications! 🚀
