
### 3.3.1 Queries on a Single Relation

### 1. **Find the names of all instructors:**
**SQL Query:**
```sql
select name
from instructor;
```
This query selects the `name` attribute from the `instructor` relation, returning a list of all instructor names.

---

### 2. **Find the department names of all instructors:**
**SQL Query:**
```sql
select dept_name
from instructor;
```
This query selects the `dept_name` attribute from the `instructor` relation, returning a list of department names for all instructors. There may be duplicates if multiple instructors belong to the same department.

---

### 3. **Find distinct department names of all instructors (removes duplicates):**
**SQL Query:**
```sql
select distinct dept_name
from instructor;
```
This query ensures that only unique department names are returned, eliminating any duplicate department names.

---

### 4. **Find the department names of all instructors (including duplicates explicitly):**
**SQL Query:**
```sql
select all dept_name
from instructor;
```
This query will include duplicates if the same department name appears multiple times in the instructor relation. The keyword `all` is optional as duplicates are allowed by default.

---

### 5. **Find the names, department names, and salaries after a 10% raise for all instructors:**
**SQL Query:**
```sql
select ID, name, dept_name, salary * 1.1
from instructor;
```
This query selects the instructor's `ID`, `name`, `dept_name`, and a 10% increase in the `salary` attribute (multiplied by 1.1).

---

### 6. **Find the names of all instructors in the 'Computer Science' department with a salary greater than $70,000:**
**SQL Query:**
```sql
select name
from instructor
where dept_name = 'Comp. Sci.' and salary > 70000;
```
This query selects the `name` attribute for instructors who belong to the 'Computer Science' department and have a salary greater than $70,000.

---

### 3.3.2 Queries on Multiple Relations

### Example Query 1:
**Query:** "Retrieve the names of all instructors, along with their department names and department building name."

SQL Query:
```sql
SELECT name, instructor.dept_name, building
FROM instructor, department
WHERE instructor.dept_name = department.dept_name;
```

---

### Example Query 2:
**Query:** "For all instructors in the university who have taught some course, find their names and the course ID of all courses they taught."

SQL Query:
```sql
SELECT name, course_id
FROM instructor, teaches
WHERE instructor.ID = teaches.ID;
```

---

### Example Query 3:
**Query:** "For all instructors in the Computer Science department who have taught some course, find their names and the course ID of all courses they taught."

SQL Query:
```sql
SELECT name, course_id
FROM instructor, teaches
WHERE instructor.ID = teaches.ID AND instructor.dept_name = 'Comp. Sci.';
```

### 3.4 Additional Basic Operations

1. **Original Query**:

   ```sql
   select name, course_id
   from instructor, teaches
   where instructor.ID = teaches.ID;
   ```

2. **Renaming Attribute** (`name` to `instructor_name`):

   ```sql
   select name as instructor_name, course_id
   from instructor, teaches
   where instructor.ID = teaches.ID;
   ```

3. **Renaming Relations** (using aliases `T` and `S`):

   ```sql
   select T.name, S.course_id
   from instructor as T, teaches as S
   where T.ID = S.ID;
   ```

4. **Query to Find Names of Instructors with Salary Greater than Some Biology Instructor**:

   ```sql
   select distinct T.name
   from instructor as T, instructor as S
   where T.salary > S.salary and S.dept_name = 'Biology';
   ```


1. **Equality Operation on Strings (Case Sensitivity)**
   ```sql
   select dept_name
   from department
   where building = 'Watson';
   ```

2. **Case-Insensitive String Matching (for MySQL or SQL Server)**
   ```sql
   select dept_name
   from department
   where building = 'watson';  -- In case-insensitive systems
   ```

3. **Concatenation, Substring, and String Functions**
   ```sql
   -- Concatenation
   select first_name || ' ' || last_name as full_name
   from employees;

   -- Extract substring
   select substring(name, 1, 5)
   from department;

   -- String length
   select length(name)
   from department;

   -- Convert to uppercase
   select upper(name)
   from department;

   -- Convert to lowercase
   select lower(name)
   from department;

   -- Trim spaces
   select trim(lead(name))
   from department;
   ```

4. **Pattern Matching with LIKE**
   ```sql
   select dept_name
   from department
   where building like '%Watson%';

   -- Other examples
   select dept_name
   from department
   where building like 'Intro%';

   select dept_name
   from department
   where building like '%Comp%';

   select dept_name
   from department
   where building like '___';

   select dept_name
   from department
   where building like '%';
   ```

5. **Using Escape Character in LIKE**
   ```sql
   select dept_name
   from department
   where building like 'ab\%cd%' escape '\';
   
   select dept_name
   from department
   where building like 'ab\\cd%' escape '\\';
   ```

6. **NOT LIKE Comparison**
   ```sql
   select dept_name
   from department
   where building not like '%Watson%';
   ```

7. **Using asterisk (*) in SELECT Clause**
   ```sql
   select instructor.*
   from instructor, teaches
   where instructor.ID = teaches.ID;
   
   select *
   from instructor;
   ```

8. **Order By Clause for Sorting**
   ```sql
   -- Sorting by name in ascending order
   select name
   from instructor
   where dept_name = 'Physics'
   order by name;
   
   -- Sorting by salary in descending order and by name in ascending order
   select *
   from instructor
   order by salary desc, name asc;
   ```

9. **BETWEEN Comparison Operator**
   ```sql
   select name
   from instructor
   where salary between 90000 and 100000;
   ```

10. **NOT BETWEEN Comparison Operator**
    ```sql
    select name
    from instructor
    where salary not between 90000 and 100000;
    ```

11. **Using Tuples in SQL**
    ```sql
    select name, course_id
    from instructor, teaches
    where instructor.ID = teaches.ID and dept_name = 'Biology';

    select name, course_id
    from instructor, teaches
    where (instructor.ID, dept_name) = (teaches.ID, 'Biology');
    ```
### 3.5 Set Operations

1. **Set of all courses taught in the Fall 2017 semester**:
   ```sql
   SELECT course_id
   FROM section
   WHERE semester = 'Fall' AND year = 2017;
   ```

2. **Set of all courses taught in the Spring 2018 semester**:
   ```sql
   SELECT course_id
   FROM section
   WHERE semester = 'Spring' AND year = 2018;
   ```

3. **Union of courses taught either in Fall 2017 or in Spring 2018 (removes duplicates)**:
   ```sql
   (SELECT course_id
    FROM section
    WHERE semester = 'Fall' AND year = 2017)
   UNION
   (SELECT course_id
    FROM section
    WHERE semester = 'Spring' AND year = 2018);
   ```

4. **Union of courses taught either in Fall 2017 or in Spring 2018 (keeps duplicates)**:
   ```sql
   (SELECT course_id
    FROM section
    WHERE semester = 'Fall' AND year = 2017)
   UNION ALL
   (SELECT course_id
    FROM section
    WHERE semester = 'Spring' AND year = 2018);
   ```

5. **Intersection of courses taught in both Fall 2017 and Spring 2018**:
   ```sql
   (SELECT course_id
    FROM section
    WHERE semester = 'Fall' AND year = 2017)
   INTERSECT
   (SELECT course_id
    FROM section
    WHERE semester = 'Spring' AND year = 2018);
   ```

6. **Intersection of courses taught in both Fall 2017 and Spring 2018 (keeps duplicates)**:
   ```sql
   (SELECT course_id
    FROM section
    WHERE semester = 'Fall' AND year = 2017)
   INTERSECT ALL
   (SELECT course_id
    FROM section
    WHERE semester = 'Spring' AND year = 2018);
   ```

7. **Except: Courses taught in Fall 2017 but not in Spring 2018**:
   ```sql
   (SELECT course_id
    FROM section
    WHERE semester = 'Fall' AND year = 2017)
   EXCEPT
   (SELECT course_id
    FROM section
    WHERE semester = 'Spring' AND year = 2018);
   ```

8. **Except: Courses taught in Fall 2017 but not in Spring 2018 (keeps duplicates)**:
   ```sql
   (SELECT course_id
    FROM section
    WHERE semester = 'Fall' AND year = 2017)
   EXCEPT ALL
   (SELECT course_id
    FROM section
    WHERE semester = 'Spring' AND year = 2018);
   ```

### 3.6 NULL Value

1. **Find all instructors who have a null salary:**
   ```sql
   select name
   from instructor
   where salary is null;
   ```

2. **Find instructors with a salary greater than 10000 where the result of the comparison is unknown:**
   ```sql
   select name
   from instructor
   where salary > 10000 is unknown;
   ```
### Aggregate Functions

1. **Find the average salary of instructors in the Computer Science department:**
   ```sql
   select avg(salary)
   from instructor
   where dept_name = 'Comp. Sci.';
   ```

2. **Find the average salary of instructors in the Computer Science department with a meaningful attribute name:**
   ```sql
   select avg(salary) as avg_salary
   from instructor
   where dept_name = 'Comp. Sci.';
   ```

3. **Find the total number of instructors who teach a course in the Spring 2018 semester, counting each instructor only once:**
   ```sql
   select count(distinct ID)
   from teaches
   where semester = 'Spring' and year = 2018;
   ```

4. **Find the total number of tuples in the course relation:**
   ```sql
   select count(*)
   from course;
   ```

5. **Find the average salary in each department:**
   ```sql
   select dept_name, avg(salary) as avg_salary
   from instructor
   group by dept_name;
   ```

6. **Find the average salary of all instructors (without grouping):**
   ```sql
   select avg(salary)
   from instructor;
   ```

7. **Find the number of instructors in each department who teach a course in the Spring 2018 semester:**
   ```sql
   SELECT instructor.dept_name, COUNT(DISTINCT teaches.ID) AS instr_count
   FROM instructor, teaches
   WHERE instructor.ID = teaches.ID AND semester = 'Spring' AND year = 2018
   GROUP BY dept_name;
   ```

8. **Erroneous query where ID does not appear in the group by clause:**
   ```sql
   /* erroneous query */
   select dept_name, ID, avg(salary)
   from instructor
   group by dept_name;
   ```

9. **Find the average salary of instructors in departments where the average salary is more than $42,000:**
   ```sql
   select dept_name, avg(salary) as avg_salary
   from instructor
   group by dept_name
   having avg(salary) > 42000;
   ```
### 3.7.3 The Having Clause

1. **Query for departments with an average salary greater than $42,000:**
   ```sql
   SELECT dept_name, AVG(salary) AS avg_salary
   FROM instructor
   GROUP BY dept_name
   HAVING AVG(salary) > 42000;
   ```

2. **Query for each course section offered in 2017, finding the average total credits of students enrolled in the section, if the section has at least 2 students:**
   ```sql
   SELECT course_id, semester, year, sec_id, AVG(tot_cred)
   FROM student, takes
   WHERE student.ID = takes.ID AND year = 2017
   GROUP BY course_id, semester, year, sec_id
   HAVING COUNT(takes.ID) >= 2;
   ```

3. **Query to calculate the sum of all salaries:**
   ```sql
   SELECT SUM(salary)
   FROM instructor;
   ```

These queries use aggregation functions like `AVG`, `SUM`, and `COUNT`, along with clauses like `GROUP BY`, `HAVING`, and `WHERE` to filter and group data.

# Nested Subqueries

## 1. Find all the courses taught in both Fall 2017 and Spring 2018
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

## 2. Find all the courses taught in Fall 2017 but not in Spring 2018
```sql
SELECT DISTINCT course_id
FROM section
WHERE semester = 'Fall' AND year = 2017
AND course_id NOT IN (
    SELECT course_id
    FROM section
    WHERE semester = 'Spring' AND year = 2018
);
```

## 3. Select the names of instructors whose names are neither “Mozart” nor “Einstein”
```sql
SELECT DISTINCT name
FROM instructor
WHERE name NOT IN ('Mozart', 'Einstein');
```

## 4. Find the total number of (distinct) students who have taken course sections taught by instructor ID 110011
```sql
SELECT COUNT(DISTINCT ID)
FROM takes
WHERE (course_id, sec_id, semester, year) IN (
    SELECT course_id, sec_id, semester, year
    FROM teaches
    WHERE teaches.ID = '10101'
);
```

## 5. Find the names of all instructors whose salary is greater than at least one instructor in the Biology department
```sql
SELECT name
FROM instructor
WHERE salary > SOME (
    SELECT salary
    FROM instructor
    WHERE dept_name = 'Biology'
);
```

## 6. Find the names of all instructors whose salary is greater than every instructor in the Biology department
```sql
SELECT name
FROM instructor
WHERE salary > ALL (
    SELECT salary
    FROM instructor
    WHERE dept_name = 'Biology'
);
```

## 7. Find the departments that have the highest average salary
```sql
SELECT dept_name
FROM instructor
GROUP BY dept_name
HAVING AVG(salary) >= ALL (
    SELECT AVG(salary)
    FROM instructor
    GROUP BY dept_name
);
```

## 8. Find all courses taught in both Fall 2017 and Spring 2018 (using EXISTS)
```sql
SELECT course_id
FROM section AS S
WHERE semester = 'Fall' AND year = 2017
AND EXISTS (
    SELECT *
    FROM section AS T
    WHERE semester = 'Spring' AND year = 2018
    AND S.course_id = T.course_id
);
```

## 9. Find all students who have taken all courses offered in the Biology department
```sql
SELECT S.ID, S.name
FROM student AS S
WHERE NOT EXISTS (
    (SELECT course_id FROM course WHERE dept_name = 'Biology')
    EXCEPT
    (SELECT T.course_id FROM takes AS T WHERE S.ID = T.ID)
);
```

## 10. Find the total number of (distinct) students who have taken course sections taught by instructor ID 110011 (alternative using EXISTS)
```sql
SELECT COUNT(DISTINCT ID)
FROM takes
WHERE EXISTS (
    SELECT course_id, sec_id, semester, year
    FROM teaches
    WHERE teaches.ID = '10101'
    AND takes.course_id = teaches.course_id
    AND takes.sec_id = teaches.sec_id
    AND takes.semester = teaches.semester
    AND takes.year = teaches.year
);
```

# 3.9 Modification of the Database
#### 1. **Delete All Tuples from the Instructor Relation**
   This query removes all records from the `instructor` table.

   ```sql
   DELETE FROM instructor;
   ```

#### 2. **Delete All Instructors from the Finance Department**
   This query deletes instructors who belong to the Finance department.

   ```sql
   DELETE FROM instructor
   WHERE dept_name = 'Finance';
   ```

#### 3. **Delete All Instructors with Salary Between $13,000 and $15,000**
   This query deletes instructors who earn between $13,000 and $15,000.

   ```sql
   DELETE FROM instructor
   WHERE salary BETWEEN 13000 AND 15000;
   ```

#### 4. **Delete All Instructors Associated with a Department in the Watson Building**
   This query deletes instructors from departments located in the Watson building.

   ```sql
   DELETE FROM instructor
   WHERE dept_name IN (
       SELECT dept_name
       FROM department
       WHERE building = 'Watson'
   );
   ```

#### 5. **Delete All Instructors with Salary Below the Average Salary**
   This query deletes instructors who earn below the average salary in the university.

   ```sql
   DELETE FROM instructor
   WHERE salary < (
       SELECT AVG(salary)
       FROM instructor
   );
   ```

#### 6. **Insert a New Course into the Course Table**
   This query adds a new course to the `course` table.

   ```sql
   INSERT INTO course
   VALUES ('CS-437', 'Database Systems', 'Comp. Sci.', 4);
   ```

#### 7. **Insert a New Course with Specified Attributes**
   This query inserts a new course by specifying individual attributes.

   ```sql
   INSERT INTO course (course_id, title, dept_name, credits)
   VALUES ('CS-437', 'Database Systems', 'Comp. Sci.', 4);
   ```

#### 8. **Insert Students from the Music Department with More Than 144 Credits into the Instructor Table**
   This query inserts students from the `Music` department who have more than 144 credits into the `instructor` table.

   ```sql
   INSERT INTO instructor
   SELECT ID, name, dept_name, 18000
   FROM student
   WHERE dept_name = 'Music' AND tot_cred > 144;
   ```

#### 9. **Insert a Student with a NULL Value for Total Credits**
   This query inserts a student record with a `NULL` value for total credits.

   ```sql
   INSERT INTO student
   VALUES ('3003', 'Green', 'Finance', NULL);
   ```

#### 10. **Increase Salary of All Instructors by 5%**
   This query increases the salary of all instructors by 5%.

   ```sql
   UPDATE instructor
   SET salary = salary * 1.05;
   ```

#### 11. **Increase Salary of Instructors Earning Less Than $70,000 by 5%**
   This query increases the salary of instructors earning less than $70,000 by 5%.

   ```sql
   UPDATE instructor
   SET salary = salary * 1.05
   WHERE salary < 70000;
   ```

#### 12. **Increase Salary of Instructors Earning Below Average by 5%**
   This query increases the salary of instructors earning below the average salary by 5%.

   ```sql
   UPDATE instructor
   SET salary = salary * 1.05
   WHERE salary < (
       SELECT AVG(salary)
       FROM instructor
   );
   ```

#### 13. **Give a 3% Raise to Instructors Earning Over $100,000 and a 5% Raise to Others**
   This query provides a 3% raise to instructors earning over $100,000 and a 5% raise to the rest.

   ```sql
   UPDATE instructor
   SET salary = salary * 1.03
   WHERE salary > 100000;

   UPDATE instructor
   SET salary = salary * 1.05
   WHERE salary <= 100000;
   ```

#### 14. **Alternative Way Using a CASE Statement**
   This query uses a `CASE` statement to give a raise: a 5% increase to those earning less than or equal to $100,000, and a 3% increase to those earning more.

   ```sql
   UPDATE instructor
   SET salary = CASE
       WHEN salary <= 100000 THEN salary * 1.05
       ELSE salary * 1.03
   END;
   ```

#### 15. **Update Total Credits of Students Based on Successfully Completed Courses**
   This query updates the total credits of students based on successfully completed courses.

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


