-- show current user
show USER; -- check kore nibo kon user e achi 

-- new profile with all the limits
create profile c##random_profile limit
   failed_login_attempts 3  -- mane 3 bar  wrong pass dile lock hbe account
   password_lock_time 1    -- mane accound lock thakbe 1 din
   password_life_time 10   --mane pass er meyad 10 din 
   password_grace_time 8   --mane meyed par howar por 8 din warning dibe pass change korar
   password_reuse_max 2    --mane  pass chnage korar time e onno pass 2 bar set korar por ager pass ta set korte parbe 
   password_reuse_time 5;  --ek pass 5 bar set kora jabe condition onujayi 

-- list all profiles -- eta diye koto gulo profile create korchi sob dekha jabe 
select profile
  from dba_profiles;

-- create a new user with the new profile  --chyle ekta profile e onek user create kora jay/jabe
create user c##random identified by random
   profile c##random_profile;

-- delete user
drop user c##random cascade; ---eta diye user delete kora jabe 

 --user ke system e grant korar jnno permission dibo,permission pele connect kora jabe..
grant
   create session
to c##random;

-- connect to the new user
connect c##random/random; 

  -- pass change kora jabe evabe 
alter user c##random identified by random2;

-- ইউজারকে টেবিল, ভিউ, এবং সিনোনিম তৈরি করার অনুমতি দেওয়া হলো।
grant
   create session,
   create table,
   create view,
   create synonym
to c##random;

-- সমস্ত টেব্লস্পেসের তালিকা দেখা।
select tablespace_name
  from dba_tablespaces;

  --DEFAULT TABLESPACE: ইউজারের ডেটা কোথায় যাবে তা ঠিক করে। QUOTA: ইউজার কতটুকু জায়গা ব্যবহার করতে পারবে তা নির্ধারণ করে।

alter user c##random
   default tablespace users
   quota 5M on users;

-- create a new table
CREATE TABLE logic_gates (
    id NUMBER PRIMARY KEY,
    name VARCHAR2(50) NOT NULL,
    description VARCHAR2(200)
);

-- list description of the table
DESCRIBE logic_gates;