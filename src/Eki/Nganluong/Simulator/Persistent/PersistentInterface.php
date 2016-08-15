<?php
/**
 * This file is part of the EkiNganluongSimulator package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\Simulator\Persistent;

interface PersistentInterface
{
	public function createToken($obj);
	public function get($token);
	public function delete($obj);
	public function save($obj);
}
