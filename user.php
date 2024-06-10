<?php
include_once(__DIR__."/connection.php");

class User extends Connection{
	private $idUser;
	private $email;
	private $password;
	private $code;
	private $lastLogin;
	private $name;
	
	public function __construct($id=null){
		parent::__construct();
		if ($id!=null){
			$this->load($id);
		}
	}
	
	public function setIdUser($id) {
		$this->idUser=$id;
	}
	
	public function setEmail($email) {
		$this->email=$email;
	}
	
	public function setPassword($pass) {
		$this->password=hash("sha512", $pass);
	}
	
	public function setCode($code) {
		$this->code=$code;
	}
	public function setName($n) {
		$this->name=$n;
	}
	
	public function getIdUser() {
		return $this->idUser;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getCode() {
		return $this->code;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getLastLogin() {
		return $this->lastLogin;
	}
	
	public function load($id){
		$this->clearErr();
		if ($id) {
			try{
				$stm=$this->getPdo()->prepare("Select * from users where id=?");
				$stm->bindParam(1, $id);
				$stm->execute();
				
				$result = $stm->fetch(PDO::FETCH_ASSOC);
				if ($result) {
					$this->idUser =	$result['id'];
					$this->email =	$result['email'];
					$this->password = $result['pass'];
					$this->code = $result['code'];
					$this->lastLogin = $this->getDateTimeToSpain($result['lastLogin']);
					$this->name = $result['name'];
					return true;
				}
			} catch (PDOException $e){
				$this->errCode=$e->getCode();
				$this->errMsg=$e->getMessage();
				return false;
			}
			
		}
		return false;
	}
	
	public function delete(){
		
		$this->clearErr();
		if ($this->idUser) {
			try{
				$stm=$this->getPdo()->prepare("delete from usuarios where id=?");
				$stm->bindParam(1, $this->idUser);
				$stm->execute();
				return true;
			} catch (PDOException $e){
				$this->errCode=$e->getCode();
				$this->errMsg=$e->getMessage();
			}
		}
		return false;
	}
	
	public function insert(){
		$this->clearErr();
		try{
			$stm=$this->getPdo()->prepare("insert into usuarios (email, password, name, code, lastLogin) values (?,?,?,?,NOW())");
			$stm->bindParam(1, $this->email);
			$stm->bindParam(2, $this->password);
			$stm->bindParam(3, $this->name);
			$stm->bindParam(4, $this->code);
			$stm->execute();
			$this->idUser=$this->getPdo()->lastInsertId();
			if ($this->idUser) return true;
		} catch (PDOException $e){
			$this->errCode=$e->getCode();
			$this->errMsg=$e->getMessage();
		}
		return false;
	}
	
	public function update(){
		$this->clearErr();
		if ($this->idUser) {
			try{
				$stm=$this->getPdo()->prepare("update usuarios set email=?, password=?, code=?, name=? where id=?");
				$stm->bindParam(1, $this->email);
				$stm->bindParam(2, $this->password);
				$stm->bindParam(3, $this->code);
				$stm->bindParam(4, $this->name);
				$stm->bindParam(5, $this->idUser);
				$stm->execute();
				return true;
			} catch (PDOException $e){
				$this->errCode=$e->getCode();
				$this->errMsg=$e->getMessage();
			}
		}
		return false;
	}
	
	public function setLastLogin(){
		$this->clearErr();
		if ($this->idUser) {
			try{
				$stm=$this->getPdo()->prepare("update usuarios set lastLogin=NOW() where id=?");
				$stm->bindParam(1, $this->idUser);
				$stm->execute();
				return true;
			} catch (PDOException $e){
				$this->errCode=$e->getCode();
				$this->errMsg=$e->getMessage();
			}
		}
		return false;
	}
	
	public function login(){
		$this->clearErr();
		try{
			$stm=$this->getPdo()->prepare("Select * from usuarios where email=? and password=? and (code is null or code = '') ");
			$stm->bindParam(1, $this->email, PDO::PARAM_STR);
			$stm->bindParam(2, $this->password, PDO::PARAM_STR);
			$stm->execute();
			
			$result = $stm->fetch(PDO::FETCH_ASSOC);
			if ($result) {
				$this->idUser=$result['id'];
				$this->setLastLogin();
				$this->load($this->idUser);
				return true;
			}
			
		} catch (PDOException $e){
			$this->errCode=$e->getCode();
			$this->errMsg=$e->getMessage();
		}
		return false;
	}
	
	public function loadByEmail(){
		$this->clearErr();
		if ($this->email) {
			try{
				$stm=$this->getPdo()->prepare("Select * from usuarios where email=?");
				$stm->bindParam(1, $this->email);
				$stm->execute();
				
				$result = $stm->fetch(PDO::FETCH_ASSOC);
				if ($result) {
					$this->idUser = $result['id'];
					$this->email = $result['email'];
					$this->password = $result['password'];
					$this->code = $result['code'];
					$this->lastLogin = $this->getDateTimeToSpain($result['lastLogin']);
					$this->name = $result['name'];
					return true;
				}
			} catch (PDOException $e){
				$this->errCode=$e->getCode();
				$this->errMsg=$e->getMessage();
				return false;
			}
			
		}
		return false;
	}
	
	
}
?>