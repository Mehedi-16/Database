# Write the following queries in relational algebra, using the university schema.
<img width="776" alt="Screenshot 2025-04-26 at 4 33 39 PM" src="https://github.com/user-attachments/assets/21e5cbee-1dc6-40e2-90f1-a7bbdfdc806a" />

### a. Find the ID and name of each instructor in the Physics department.

**Relational Algebra Expression**:
```plaintext
∏ ID, name (
  σ department = 'Physics' (instructor)
)
```

**ব্যাখ্যা**:
- **σ department = 'Physics' (instructor)**: `instructor` টেবিল থেকে সেই ইনস্ট্রাক্টরদের সিলেক্ট করা হচ্ছে, যাদের বিভাগের নাম "Physics"।
- **∏ ID, name**: সিলেক্ট করা ইনস্ট্রাক্টরদের `ID` এবং `name` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

### b. Find the ID and name of each instructor in a department located in the building "Watson".

**Relational Algebra Expression**:
```plaintext
∏ ID, name (
  σ building = 'Watson' (department)
  ⨝ instructor
)
```

**ব্যাখ্যা**:
- **σ building = 'Watson' (department)**: `department` টেবিল থেকে সিলেক্ট করা হচ্ছে সেই বিভাগের রেকর্ড, যেগুলি "Watson" বিল্ডিংয়ে অবস্থিত।
- **⨝ instructor**: `department` টেবিলকে `instructor` টেবিলের সাথে যোগ করা হচ্ছে, যাতে সেই বিভাগে কর্মরত ইনস্ট্রাক্টরদের তথ্য পাওয়া যায়।
- **∏ ID, name**: ইনস্ট্রাক্টরদের `ID` এবং `name` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

### c. Find the ID and name of each student who has taken at least one course in the “Comp. Sci.” department.

**Relational Algebra Expression**:
```plaintext
∏ ID, name (
  σ department = 'Comp. Sci.' (course)
  ⨝ takes
  ⨝ student
)
```

**ব্যাখ্যা**:
- **σ department = 'Comp. Sci.' (course)**: `course` টেবিল থেকে সিলেক্ট করা হচ্ছে সেই কোর্সগুলো, যেগুলি "Comp. Sci." বিভাগের অন্তর্গত।
- **⨝ takes**: তারপর `course` টেবিলকে `takes` টেবিলের সাথে যোগ করা হচ্ছে, যাতে জানানো হয় কোন ছাত্র কোন কোর্স নিয়েছে।
- **⨝ student**: `takes` টেবিলকে `student` টেবিলের সাথে যোগ করা হচ্ছে, যাতে ছাত্রদের তথ্য পাওয়া যায়।
- **∏ ID, name**: ছাত্রদের `ID` এবং `name` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

### d. Find the ID and name of each student who has taken at least one course section in the year 2018.

**Relational Algebra Expression**:
```plaintext
∏ ID, name (
  σ year = 2018 (section)
  ⨝ takes
  ⨝ student
)
```

**ব্যাখ্যা**:
- **σ year = 2018 (section)**: `section` টেবিল থেকে সিলেক্ট করা হচ্ছে সেই কোর্স সেকশনগুলো, যেগুলি ২০১৮ সালে অনুষ্ঠিত হয়েছে।
- **⨝ takes**: তারপর `section` টেবিলকে `takes` টেবিলের সাথে যোগ করা হচ্ছে, যাতে জানা যায় কোন ছাত্র কোন কোর্স সেকশন নিয়েছে।
- **⨝ student**: `takes` টেবিলকে `student` টেবিলের সাথে যোগ করা হচ্ছে, যাতে ছাত্রদের তথ্য পাওয়া যায়।
- **∏ ID, name**: ছাত্রদের `ID` এবং `name` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

### e. Find the ID and name of each student who has not taken any course section in the year 2018.

**Relational Algebra Expression**:
```plaintext
∏ ID, name (
  student
  - ∏ ID (
      σ year = 2018 (section)
      ⨝ takes
  )
)
```

**ব্যাখ্যা**:
- **σ year = 2018 (section)**: `section` টেবিল থেকে সিলেক্ট করা হচ্ছে সেই কোর্স সেকশনগুলো, যেগুলি ২০১৮ সালে অনুষ্ঠিত হয়েছে।
- **⨝ takes**: তারপর `section` টেবিলকে `takes` টেবিলের সাথে যোগ করা হচ্ছে, যাতে জানা যায় কোন ছাত্র কোন কোর্স সেকশন নিয়েছে।
- **∏ ID**: ২০১৮ সালে কোর্স সেকশন নেওয়া ছাত্রদের `ID` প্রজেক্ট করা হচ্ছে।
- **student -**: সব ছাত্রদের মধ্যে থেকে ২০১৮ সালে কোর্স সেকশন নেওয়া ছাত্রদের `ID` বাদ দেওয়া হচ্ছে, অর্থাৎ যেসব ছাত্র ২০১৮ সালে কোর্স সেকশন নেয়নি তাদের বের করা হচ্ছে।
- **∏ ID, name**: অবশেষে ছাত্রদের `ID` এবং `name` কলামগুলো প্রজেক্ট করা হচ্ছে।

---

এইসব প্রশ্নের জন্য রিলেশনাল অ্যালজেব্রা সঠিকভাবে রচিত হয়েছে। যদি আরও কোনো সাহায্য প্রয়োজন হয়, জানাবেন!
