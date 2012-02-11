<?php
	Class extension_icaptcha extends Extension
	{
		/*-------------------------------------------------------------------------
			Extension definition
		-------------------------------------------------------------------------*/
	
	public function about()
		{
			return array(
				'name' => 'iCaptcha',
				'version'	=> '0.0.1',
				'author'	=> array('name' => 'Ilya Zhuravlev',
									'website' => 'http://ibcico.com/',
									'email' => 'i.zhuravlev@ibcico.com'),
				'release-date' => '2011-20-12',
			);
		}
		
		
		
	public function getSubscribedDelegates()
		{
			return array(
			array(
					'page'		=> '/blueprints/events/edit/',
					'delegate'	=> 'AppendEventFilter',
					'callback'	=> 'appendEventFilter'
				),				
				array(
					'page'		=> '/blueprints/events/new/',
					'delegate'	=> 'AppendEventFilter',
					'callback'	=> 'appendEventFilter'
				),
				array(
					'page'		=> '/frontend/',
					'delegate'	=> 'EventPreSaveFilter',
					'callback'	=> 'eventPreSaveFilter'
				),
			);
		}
				
		
	public function appendEventFilter(&$context)
		{
			$context['options'][] = array('icaptcha', @in_array('icaptcha', $context['selected']) ,'iCaptcha');
		}
	
	public function eventPreSaveFilter($context)
		{
			if (in_array('commentary-injector', $context['event']->eParamFILTERS)){
				ob_start();
				session_start();
				
				if($_POST['fields']['captcha']){
					$captcha = $_POST['fields']['captcha'];
					if($captcha != $_SESSION['captcha']){
						$context['messages'][] = array('captcha', false, 'incorrect captcha');
					}
				}else{
					$context['messages'][] = array('captcha', false, 'incorrect captcha');
				}
				ob_end_flush();
			}
		}
	}