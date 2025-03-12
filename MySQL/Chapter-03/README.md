
# SQL Queries for University Database

These SQL queries are designed to retrieve and manipulate data from the tables after importing `create_table` and `largeRelationsInsertFile.sql` into the `University` database.

## Basic Queries

1. **Retrieve Department Names from Instructor Table**
    ```sql
    SELECT dept_name  
    FROM instructor;
    ```

2. **Calculate 10% Salary Increase for Instructors**
    ```sql
    SELECT ID, name, dept_name, salary * 1.1 
    FROM instructor;
    ```

3. **Retrieve Instructors in Computer Science with Salary > 70000**
    ```sql
    SELECT name 
    FROM instructor 
    WHERE dept_name = 'Comp. Sci.' AND salary > 70000;
    ```

4. **Join Instructor and Department Tables**
    ```sql
    SELECT instructor.name, instructor.dept_name, department.building
    FROM instructor, department
    WHERE instructor.dept_name = department.dept_name;
    ```

5. **Join Instructor and Teaches Tables**
    ```sql
    SELECT instructor.name, teaches.course_id
    FROM instructor, teaches
    WHERE instructor.ID = teaches.ID;
    ```

6. **Retrieve Instructors in Computer Science with Their Course IDs**
    ```sql
    SELECT instructor.name, teaches.course_id
    FROM instructor, teaches
    WHERE instructor.ID = teaches.ID AND instructor.dept_name = 'Comp. Sci.';
    ```

7. **Alias Usage in Queries**
    ```sql
    SELECT name AS instructor_name, course_id AS cor
    FROM instructor, teaches
    WHERE instructor.ID = teaches.ID;
    ```

8. **Alias Usage with Table Names**
    ```sql
    SELECT T.name, S.course_id
    FROM instructor AS T, teaches AS S
    WHERE T.ID = S.ID;
    ```

9. **Find the names of all instructors whose salary is greater than at least one instructor
in the Biology department**
    ```sql
    SELECT DISTINCT T.name
    FROM instructor AS T, instructor AS S
    WHERE T.salary > S.salary AND S.dept_name = 'Biology';
    ```
- Using some
```sql
select name
from instructor
where salary > some (select salary
from instructor
where dept name = 'Biology');
```
10. **Retrieve Departments in Buildings Containing "Whit"**
    ```sql
    SELECT dept_name 
    FROM department 
    WHERE building LIKE '%Whit%';
    ```

11. **Retrieve Physics Instructors Ordered by Name**
    ```sql
    SELECT name 
    FROM instructor 
    WHERE dept_name = 'Physics' ORDER BY name;
    ```

12. **Retrieve All Instructors Ordered by Salary (Descending) and Name (Ascending)**
    ```sql
    SELECT * 
    FROM instructor 
    ORDER BY salary DESC, name ASC;
    ```
- ORDER BY salary DESC → প্রথমে salary কলাম অনুযায়ী সাজাবে, যেখানে সবচেয়ে বেশি বেতনপ্রাপ্ত ব্যক্তির তথ্য প্রথমে আসবে।

  name ASC → যদি দুইজনের salary একই হয়, তাহলে তাদের নাম বর্ণানুক্রমিকভাবে (A-Z) সাজাবে।

13. **Retrieve Instructors with Salaries Between 90000 and 100000**
    ```sql
    SELECT name 
    FROM instructor 
    WHERE salary BETWEEN 90000 AND 100000;
    ```

14. **Retrieve Instructors with Salaries Between 90000 and 100000 (Alternative)**
    ```sql
    SELECT name 
    FROM instructor 
    WHERE salary <= 100000 AND salary >= 90000;
    ```

15. **Retrieve Biology Instructors and Their Course IDs**
    ```sql
    SELECT instructor.name, teaches.course_id
    FROM instructor, teaches
    WHERE instructor.ID = teaches.ID AND dept_name = 'Biology';
    ```

16. **Retrieve Biology Instructors and Their Course IDs (Alternative)**
    ```sql
    SELECT instructor.name, teaches.course_id
    FROM instructor, teaches
    WHERE (instructor.ID, dept_name) = (teaches.ID, 'Biology');
    ```

## Set Operations

1. **Union of Courses in Fall 2017 and Spring 2018**
    ```sql
    (SELECT course_id FROM section WHERE semester = 'Fall' AND year = 2017)
    UNION
    (SELECT course_id FROM section WHERE semester = 'Spring' AND year = 2018);
    ```

2. **Intersection of Courses in Fall 2017 and Spring 2018**
    ```sql
    (SELECT course_id FROM section WHERE semester = 'Fall' AND year = 2017)
    INTERSECT
    (SELECT course_id FROM section WHERE semester = 'Spring' AND year = 2018);
    ```

3. **Intersection of Courses in Fall 2017 and Spring 2018 (Including Duplicates)**
    ```sql
    (SELECT course_id FROM section WHERE semester = 'Fall' AND year = 2017)
    INTERSECT ALL
    (SELECT course_id FROM section WHERE semester = 'Spring' AND year = 2018);
    ```

4. **Courses in Fall 2017 but Not in Spring 2018**
    ```sql
    (SELECT course_id FROM section WHERE semester = 'Fall' AND year = 2017)
    EXCEPT
    (SELECT course_id FROM section WHERE semester = 'Spring' AND year = 2018);
    ```

5. **Courses in Fall 2017 but Not in Spring 2018 (Including Duplicates)**
    ```sql
    (SELECT course_id FROM section WHERE semester = 'Fall' AND year = 2017)
    EXCEPT ALL
    (SELECT course_id FROM section WHERE semester = 'Spring' AND year = 2018);
    ```

## Advanced Queries

1. **Retrieve Instructors with Null Salary**
    ```sql
    SELECT name FROM instructor WHERE salary IS NULL;
    ```

2. **Retrieve Instructors with Unknown Salary Status**
    ```sql
    SELECT name FROM instructor WHERE salary > 10000 IS UNKNOWN;
    ```

3. **Calculate Average Salary in Computer Science Department**
    ```sql
    SELECT AVG(salary) FROM instructor WHERE dept_name = 'Comp. Sci.';
    ```

4. **Count Distinct Instructors Teaching in Spring 2018**
    ```sql
    SELECT COUNT(DISTINCT ID) FROM teaches WHERE semester = 'Spring' AND year = 2018;
    ```

5. **Retrieve Departments with Average Salary > 42000**
    ```sql
    SELECT dept_name, avg_salary
    FROM (
        SELECT dept_name, AVG(salary) AS avg_salary
        FROM instructor
        GROUP BY dept_name
    ) AS subquery
    WHERE avg_salary > 42000;
    ```
- ১. সাবকোয়েরি (subquery) কী করছে?
    ```
    SELECT dept_name, AVG(salary) AS avg_salary
    FROM instructor
    GROUP BY dept_name;
    ```
    ➡ এখানে instructor টেবিল থেকে প্রতিটি dept_name অনুযায়ী salary এর গড় (AVG) বের করা হচ্ছে।
    ➡ এটি subquery হিসেবে কাজ করবে এবং একটি নতুন অস্থায়ী টেবিল তৈরি করবে, যাকে subquery বলা হয়েছে।

- ২. মেইন কোয়েরি কী করছে?
```
    SELECT dept_name, avg_salary
    FROM (subquery)
    WHERE avg_salary > 42000;
```
    ➡ এখন এই subquery থেকে কেবল যেসব dept_name-এর avg_salary 42000-এর বেশি, সেগুলো ফিল্টার করা হচ্ছে।

6. **Count Total Courses**
    ```sql
    SELECT COUNT(*) FROM course;
    ```

7. **Group Instructors by Department and Calculate Average Salary**
    ```sql
    SELECT dept_name, AVG(salary) AS avg_salary
    FROM instructor
    GROUP BY dept_name;
    ```

8. **Find
      the number of instructors in each department who teach a course in the Spring 2018
      semester.**
    ```sql
    SELECT instructor.dept_name, COUNT(DISTINCT teaches.ID) AS instr_count
    FROM instructor, teaches
    WHERE instructor.ID = teaches.ID AND semester = 'Spring' AND year = 2018
    GROUP BY dept_name;
    ```

9. **we might be interested in only those departments where the average salary of
the instructors is more than $42,000.(Using HAVING)**
    ```sql
    SELECT dept_name, AVG(salary) AS avg_salary
    FROM instructor
    GROUP BY dept_name
    HAVING AVG(salary) > 42000;
    ```

10. **For each course section oﬀered in 2017, find the average total
credits (tot cred) of all students enrolled in the section, if the section has at least 2
students.**
    ```sql
    SELECT course_id, semester, year, sec_id, AVG(tot_cred)
    FROM student, takes
    WHERE student.ID = takes.ID AND year = 2017
    GROUP BY course_id, semester, year, sec_id
    HAVING COUNT(student.ID) >= 2;
    ```

11. **Calculate Total Salary of All Instructors**
    ```sql
    SELECT SUM(salary) FROM instructor;
    ```

12. **Retrieve Courses in Spring 2018**
    ```sql
    SELECT course_id FROM section WHERE semester = 'Spring' AND year = 2018;
    ```

13. **Find all the courses taught in the both the
Fall 2017 and Spring 2018 semesters.**
    ```sql
    SELECT DISTINCT course_id
    FROM section
    WHERE semester = 'Fall' AND year = 2017
    AND course_id IN (
        SELECT course_id
        FROM section
        WHERE semester = 'Spring' AND year = 2018
    );
    ```

14. **Count Students Taught by Instructor 10101**
    ```sql
    SELECT COUNT(DISTINCT ID)
    FROM takes
    WHERE (course_id, sec_id, semester, year) IN (
        SELECT course_id, sec_id, semester, year
        FROM teaches
        WHERE teaches.ID = '10101'
    );
    ```
14. **TO find
all the courses taught in the Fall 2017 semester but not in the Spring 2018 semester.**
    ```sql
    SELECT COUNT(DISTINCT ID)
    FROM takes
    WHERE (course_id, sec_id, semester, year) NOT IN (
        SELECT course_id, sec_id, semester, year
        FROM teaches
        WHERE teaches.ID = '10101'
    );
    ```

15. **“Find the departments
that have the highest average salary.”**
```sql
select dept name
from instructor
group by dept_name
having avg (salary) >= all (select avg (salary)
from instructor
group by dept_name);
```
## 3.8.3 Test for Empty Relations
Q1: **Find all courses taught in both the Fall 2017
semester and in the Spring 2018 semester**
```sql
select course_id
from section as S
where semester = 'Fall' and year= 2017 and
exists (select *
from section as T
where semester = 'Spring' and year= 2018 and
S.course id= T .course id);
```
Q2: **Find all students who have taken all courses oﬀered in the Biology
department.(Using the except construct)**
```sql
select S.ID, S.name
from student as S
where not exists ((select course_id
from course
where dept_name = 'Biology')
except
(select_T .course_id
from takes as T
where S.ID =T .ID));
```
- Here, the subquery:
```
select course id
from course
where dept name = 'Biology';
```
finds the set of all courses oﬀered in the Biology department. 
The subquery:
```subquery
select T .course id
from takes as T
where S.ID =T .ID)
```

## 3.8.4 Test for the Absence of Duplicate Tuples
**Q1: Find All Courses That Were Offered at Most Once in 2017**
```sql
SELECT T.course_id
FROM course AS T
WHERE 1 >= (
    SELECT COUNT(R.course_id)
    FROM section AS R
    WHERE T.course_id = R.course_id AND R.year = 2017
);
```
**Q2:Find All Courses That Were Offered at Least Twice in 2017**
```sql
SELECT T.course_id
FROM course AS T
WHERE 1 < (
    SELECT COUNT(R.course_id)
    FROM section AS R
    WHERE T.course_id = R.course_id AND R.year = 2017
);
```
Alternative

Alternative Method Using HAVING (More Efficient)
✅ Find Courses Offered at Most Once in 2017
```
SELECT course_id
FROM section
WHERE year = 2017
GROUP BY course_id
HAVING COUNT(course_id) <= 1;
```
➡ This directly groups by course_id and filters courses offered 0 or 1 times.

✅ Find Courses Offered at Least Twice in 2017
```
SELECT course_id
FROM section
WHERE year = 2017
GROUP BY course_id
HAVING COUNT(course_id) >= 2;
```
➡ This groups by course_id and filters courses offered 2 or more times.


## 3.8.5 Subqueries in the From Clause
**Q1: Find the average instructors’ salaries of those departments
where the average salary is greater than $42,000.**
```sql
select dept_name, avg_salary
from (select dept_name, avg (salary) as avg_salary
from instructor
group by dept_name)
where avg_salary > 42000;```
```


15. **Retrieve Instructors 
with Salaries Higher Than Some Biology Instructor**
    ```sql
    SELECT name
    FROM instructor
    WHERE salary > SOME (
        SELECT salary
        FROM instructor
        WHERE dept_name = 'Biology'
    );
    ```

16. **Retrieve Instructors with Salaries Higher Than All Biology Instructors**
    ```sql
    SELECT name
    FROM instructor
    WHERE salary > ALL (
        SELECT salary
        FROM instructor
        WHERE dept_name = 'Biology'
    );
    ```

17. **Count of Distinct IDs**
    ```sql
    SELECT COUNT(DISTINCT ID)
    FROM takes
    WHERE EXISTS (
        SELECT 1
        FROM teaches
        WHERE teaches.ID = '10101'
          AND takes.course_id = teaches.course_id
          AND takes.sec_id = teaches.sec_id
          AND takes.semester = teaches.semester
          AND takes.year = teaches.year
    );
    ```

18. **Courses with Single Section in 2017**
    ```sql
    SELECT T.course_id
    FROM course AS T
    WHERE T.course_id IN (
        SELECT R.course_id
        FROM section AS R
        WHERE R.year = 2017
        GROUP BY R.course_id
        HAVING COUNT(R.course_id) = 1
    );
    ```

19. **Courses with Sections in 2017**
    ```sql
    SELECT T.course_id
    FROM course AS T
    WHERE 1 >= (
        SELECT COUNT(*)
        FROM section AS R
        WHERE T.course_id = R.course_id AND R.year = 2017
    );
    ```

20. **Courses without Sections in 2017**
    ```sql
    SELECT T.course_id
    FROM course AS T
    WHERE NOT EXISTS (
        SELECT R.course_id
        FROM section AS R
        WHERE T.course_id = R.course_id AND R.year = 2017
        GROUP BY R.course_id
        HAVING COUNT(*) = 1
    );
    ```

21. **Max Total Salary per Department**
    ```sql
    SELECT MAX(tot_salary)
    FROM (
        SELECT dept_name, SUM(salary) AS tot_salary
        FROM instructor
        GROUP BY dept_name
    ) AS dept_total;
    ```

22. **Max Budget in Department**
    ```sql
    WITH max_budget AS (
        SELECT MAX(budget) AS value
        FROM department
    )
    SELECT budget
    FROM department, max_budget
    WHERE department.budget = max_budget.value;
    ```

## 3.9 Modification of the Database 

---

**Question 1:**  
Delete all **instructors** in the **Finance** department using an SQL command.

🔹 **SQL Command:**  
```sql
DELETE FROM instructor
WHERE dept_name = 'Finance';
```

---

**Question 2:**  
Delete all **instructors** whose salary is between **$13,000 and $15,000** using an SQL command.

🔹 **SQL Command:**  
```sql
DELETE FROM instructor
WHERE salary BETWEEN 13000 AND 15000;
```

---

**Question 3:**  
Delete all **instructors** from departments located in the **Watson** building using an SQL command.

🔹 **SQL Command:**  
```sql
DELETE FROM instructor
WHERE dept_name IN (
    SELECT dept_name 
    FROM department 
    WHERE building = 'Watson'
);
```

---

**Question 4:**  
Delete all **instructors** whose salary is below the average salary using an SQL command.

🔹 **SQL Command:**  
```sql
DELETE FROM instructor
WHERE salary < (
    SELECT AVG(salary) 
    FROM instructor
);
```

---

**Question 5:**  
Insert a new **CS-437** course (Database Systems, Computer Science department, 4 credits) using an SQL command.

🔹 **SQL Command:**  
```sql
INSERT INTO course
VALUES ('CS-437', 'Database Systems', 'Comp. Sci.', 4);
```
**Or:**  
```sql
INSERT INTO course (course_id, title, dept_name, credits)
VALUES ('CS-437', 'Database Systems', 'Comp. Sci.', 4);
```

---

**Question 6:**  
Insert students from the **Music** department who have a total of more than **144 credits** as **instructors** with a salary of **$18,000** using an SQL command.

🔹 **SQL Command:**  
```sql
INSERT INTO instructor
SELECT ID, name, dept_name, 18000
FROM student
WHERE dept_name = 'Music' AND tot_cred > 144;
```

---

**Question 7:**  
Increase the salary of all **instructors** by 5% using an SQL command.

🔹 **SQL Command:**  
```sql
UPDATE instructor
SET salary = salary * 1.05;
```

---

**Question 8:**  
Increase the salary by 5% for all **instructors** whose salary is less than **$70,000** using an SQL command.

🔹 **SQL Command:**  
```sql
UPDATE instructor
SET salary = salary * 1.05
WHERE salary < 70000;
```

---

**Question 9:**  
Increase the salary by 5% for all **instructors** whose salary is below the average salary using an SQL command.

🔹 **SQL Command:**  
```sql
UPDATE instructor
SET salary = salary * 1.05
WHERE salary < (
    SELECT AVG(salary) 
    FROM instructor
);
```

---

**Question 10:**  
Increase the salary by **3%** for all **instructors** earning more than **$100,000** and by **5%** for those earning **$100,000 or less** using an SQL command.

🔹 **SQL Command:**  
```sql
UPDATE instructor
SET salary = CASE 
    WHEN salary <= 100000 THEN salary * 1.05
    ELSE salary * 1.03
END;
```

---

**Question 11:**  
Update the **tot_cred** for each student, where **tot_cred** is the sum of credits from all successfully completed courses using an SQL command.

🔹 **SQL Command:**  
```sql
UPDATE student
SET tot_cred = (
    SELECT SUM(credits)
    FROM takes, course
    WHERE student.ID = takes.ID 
    AND takes.course_id = course.course_id 
    AND takes.grade <> 'F' 
    AND takes.grade IS NOT NULL
);
```

---

These are the questions and SQL commands in the same style you provided. Let me know if you need any changes! 😊

23. **Departments Above Average Salary**
    ```sql
    WITH dept_total AS (
        SELECT dept_name, SUM(salary) AS value
        FROM instructor
        GROUP BY dept_name
    ),
    dept_total_avg AS (
        SELECT AVG(value) AS avg_value
        FROM dept_total
    )
    SELECT dept_name
    FROM dept_total, dept_total_avg
    WHERE dept_total.value > dept_total_avg.avg_value;
    ```

24. **Count of Instructors per Department**
    ```sql
    SELECT dept_name,
    (
        SELECT COUNT(*)
        FROM instructor
        WHERE department.dept_name = instructor.dept_name
    ) AS num_instructors
    FROM department;
    ```

25. **Delete Instructors by Department**
    ```sql
    DELETE FROM instructor
    WHERE dept_name = 'Finance';
    ```

26. **Delete Instructors by Salary**
    ```sql
    DELETE FROM instructor
    WHERE salary < 50000;
    ```

## Additional SQL Queries

### Aggregate Functions with Conditions

1. **Find the Maximum Salary for Instructors in Each Department**
    ```sql
    SELECT dept_name, MAX(salary) AS max_salary
    FROM instructor
    GROUP BY dept_name;
    ```

2. **Find the Total Salary for Each Department**
    ```sql
    SELECT dept_name, SUM(salary) AS total_salary
    FROM instructor
    GROUP BY dept_name;
    ```

3. **Average Salary of Instructors by Department (Excluding Null Salaries)**
    ```sql
    SELECT dept_name, AVG(salary) AS avg_salary
    FROM instructor
    WHERE salary IS NOT NULL
    GROUP BY dept_name;
    ```

4. **Count of Instructors with Salary Greater Than 50,000**
    ```sql
    SELECT COUNT(*) AS count_instructors
    FROM instructor
    WHERE salary > 50000;
    ```

5. **Departments with More Than 10 Instructors**
    ```sql
    SELECT dept_name
    FROM instructor
    GROUP BY dept_name
    HAVING COUNT(*) > 10;
    ```

6. **Retrieve Courses Taught by Instructors from a Specific Department (e.g., Computer Science)**
    ```sql
    SELECT course_id
    FROM teaches
    WHERE ID IN (SELECT ID FROM instructor WHERE dept_name = 'Comp. Sci.');
    ```

7. **Retrieve Instructors Teaching More Than One Course**
    ```sql
    SELECT instructor.name
    FROM instructor, teaches
    WHERE instructor.ID = teaches.ID
    GROUP BY instructor.name
    HAVING COUNT(teaches.course_id) > 1;
    ```

8. **List of Students Enrolled in the Most Number of Courses**
    ```sql
    SELECT student.ID, COUNT(*) AS course_count
    FROM student, takes
    WHERE student.ID = takes.ID
    GROUP BY student.ID
    ORDER BY course_count DESC
    LIMIT 1;
    ```

### Subqueries and Nested Queries

9. **Retrieve Instructors with Salaries Higher Than the Average Salary of All Instructors**
    ```sql
    SELECT name
    FROM instructor
    WHERE salary > (SELECT AVG(salary) FROM instructor);
    ```

10. **Retrieve Students Who Have Enrolled in All Courses Taught by a Specific Instructor (e.g., Instructor ID = 10101)**
    ```sql
    SELECT student.ID
    FROM student
    WHERE NOT EXISTS (
        SELECT 1
        FROM teaches
        WHERE teaches.ID = '10101'
          AND NOT EXISTS (
              SELECT 1
              FROM takes
              WHERE takes.ID = student.ID
                AND takes.course_id = teaches.course_id
                AND takes.semester = teaches.semester
                AND takes.year = teaches.year
          )
    );
    ```

11. **Departments with More Than One Instructor Earning the Maximum Salary**
    ```sql
    SELECT dept_name
    FROM instructor
    WHERE salary = (SELECT MAX(salary) FROM instructor)
    GROUP BY dept_name
    HAVING COUNT(dept_name) > 1;
    ```

### Date and Time Queries

12. **Retrieve Courses Taught in a Specific Year (e.g., 2018)**
    ```sql
    SELECT course_id
    FROM section
    WHERE year = 2018;
    ```

13. **Retrieve Students Who Took Courses in Both Fall 2017 and Spring 2018**
    ```sql
    SELECT DISTINCT student.ID
    FROM student, takes
    WHERE student.ID = takes.ID
      AND EXISTS (
          SELECT 1
          FROM section
          WHERE section.semester = 'Fall'
            AND section.year = 2017
            AND section.course_id = takes.course_id
      )
      AND EXISTS (
          SELECT 1
          FROM section
          WHERE section.semester = 'Spring'
            AND section.year = 2018
            AND section.course_id = takes.course_id
      );
    ```

### Cleanup Queries

14. **Remove Instructors with Null or Missing Names**
    ```sql
    DELETE FROM instructor
    WHERE name IS NULL OR name = '';
    ```

15. **Delete All Courses from a Specific Department**
    ```sql
    DELETE FROM course
    WHERE dept_name = 'History';
    ```

### Miscellaneous Queries

16. **List of Courses with More Than 3 Sections in 2017**
    ```sql
    SELECT course_id
    FROM section
    WHERE year = 2017
    GROUP BY course_id
    HAVING COUNT(course_id) > 3;
    ```

17. **Find Instructors Who Teach Courses in More Than One Semester**
    ```sql
    SELECT instructor.name
    FROM instructor, teaches
    WHERE instructor.ID = teaches.ID
    GROUP BY instructor.name
    HAVING COUNT(DISTINCT teaches.semester) > 1;
    ```
