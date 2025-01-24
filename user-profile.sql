show user -->1st check kore nibo user kise ache
CREATE USER C##test IDENTIFIED BY test; -->then ekta user create kore nibo/ chyle profile o age create kora jabe 
GRANT CREATE SESSION TO C##test;--> then user ke system e grant korar jnno permission dibo,permission pele connect kora jabe..
CONNECT C##TEST/test; --> run korlei connect hbe then check korbo user koi ache (CONNECT C##TEST/test; show user;) ek shatei run korle user er name dekhte pabo


--ekhon chyle ami user ke ekta profile e rakhte pari / ageo create kore nite pari then user korte pari (iccha)
CREATE PROFILE C##LIMITED_WITH_TIME LIMIT  -->profile name ekta dite hbe (ekhane LIMITED_WITH_TIME ) -- নতুন প্রোফাইল তৈরি: তিনবার ভুল পাসওয়ার্ড দিলে একদিনের জন্য লক হবে
    FAILED_LOGIN_ATTEMPTS 3
    PASSWORD_LOCK_TIME 1
    ;

    --another profile ---> chyle ager ta use na kore etao kora jabe 

ALTER PROFILE C##LIMITED_WITH_TIME LIMIT
    PASSWORD_LIFE_TIME 10   -- mane pass er meyad 10 din(10 din por kaj korbe na)
    PASSWORD_GRACE_TIME 8   --mane meyed par howar por 8 din warning dibe pass change korar
    PASSWORD_REUSE_MAX 3    --mane  pass chnage korar time e onno pass 3 bar set korar por ager pass ta set korte parbe 
    PASSWORD_REUSE_TIME UNLIMITED; -- mane pass sarajibon use kora jabe (condition mene ektu agei to dekhlam 3 bar oono pass set korte hbe then ager ta abar deya jabe )


-- ekhon ei profile e user ke rakhboo
ALTER USER c##test PROFILE c##LIMITED_WITH_TIME; --> rakhlam...
--er por
CONNECT C##TEST/test;
-- er por vhul pass (mane 'test' na diye 123 or onno kichu  ) dile  condition onujayi lock hbe or pass change korte hbe or warning dibee 

---then normal lock hole (iccha koreo lock kora jay 'ALTER USER c##test ACCOUNT LOCK;' eta use korlei hoy )

ALTER USER c##test ACCOUNT UNLOCK;

-- ar warning dile pass change korte hbe 

