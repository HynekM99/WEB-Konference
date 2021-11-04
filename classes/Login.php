<?php
class MyLogin {
    private const SESSION_KEY = "usr";
    private const KEY_NAME = "name";
    private const KEY_DATE = "date";

    private MySession $session;

    public function __construct()
    {
        require_once("MySession.class.php");
        $this->session = new MySession();
    }

    public function login(string $name) {
        $info = [self::KEY_NAME => $name, self::KEY_DATE => date("d. m. Y G:i:s")];
        $this->session->setSession(self::SESSION_KEY, $info);
    }

    public function isLogged(): bool {
        return $this->session->isSession(self::SESSION_KEY);
    }

    public function logout() {
        $this->session->removeSession(self::SESSION_KEY);
    }

    public function getUserInfo() {
        $info = $this->session->readSession(self::SESSION_KEY);
        return "
            Jméno: ".$info[self::KEY_NAME]." <br>
            Datum: ".$info[self::KEY_DATE]." <br>
        ";
    }
}
?>