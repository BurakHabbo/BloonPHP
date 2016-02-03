<?php
class Thread1 extends Thread {
	public function __construct(SharedThing $k){
		$this->k = $k;
	}

    public function run() {
    	while(true){
        	$this->k->setX();
        	print("COUNT #1 : ".count($this->k->thing)."\n");
        	
        	sleep(1);
    	}
    }
}

class Thread2 extends Thread {
	public function __construct(SharedThing $k){
		$this->k = $k;
	}

    public function run() {
    	while(true){
        	//$this->k->setX();
        	$this->k->thing[] = 0;
        	print("COUNT #2 : ".count($this->k->thing)."\n");
        	usleep(500000);
    	}
    }
}

class SharedThing extends Threaded{
	public $thing;

	public function __construct(){
		$this->thing = [];
		$this->thing[] = 5;
		$this->thing[] = 4;
	}

	public function setX(){
		$this->thing[] = 3;
		$this->thing[] = 2;
		$this->thing[] = 1;
	}
}

$shared = new SharedThing();

$thread1 = new Thread1($shared);
$thread1->start();

$thread2 = new Thread2($shared);
$thread2->start();

//$thread1->join();
//$thread2->join();
?>