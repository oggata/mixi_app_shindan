<?php
/* SVN FILE: $Id$ */
/**
 * Validation Class Test Case
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
App::import('Core', 'Validation');
/**
 * CustomValidator class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class CustomValidator {
/**
 * Makes sure that a given $email address is valid and unique
 *
 * @param string $email
 * @return boolean
 * @access public
 */
	function customValidate($check) {
		return preg_match('/^[0-9]{3}$/', $check);
	}
}

/**
 * Test Case for Validation Class
 *
 * @package       cake.tests
 * @subpackage    cake.tests.cases.libs
 */
class ValidationTestCase extends CakeTestCase {
/**
 * Validation property
 *
 * @var mixed null
 * @access public
 */
	var $Validation = null;
/**
 * setup method
 *
 * @access public
 * @return void
 */
	function setup() {
		$this->Validation =& Validation::getInstance();
	}
/**
 * testNotEmpty method
 *
 * @access public
 * @return void
 */
	function testNotEmpty() {
		$this->assertTrue(Validation::notEmpty('abcdefg'));
		$this->assertTrue(Validation::notEmpty('fasdf '));
		$this->assertTrue(Validation::notEmpty('fooo'.chr(243).'blabla'));

		$this->assertFalse(Validation::notEmpty("\t "));
		$this->assertFalse(Validation::notEmpty(""));
	}
/**
 * testAlphaNumeric method
 *
 * @access public
 * @return void
 */
	function testAlphaNumeric() {
		$this->assertTrue(Validation::alphaNumeric('frferrf'));
		$this->assertTrue(Validation::alphaNumeric('12234'));
		$this->assertTrue(Validation::alphaNumeric('1w2e2r3t4y'));
		$this->assertTrue(Validation::alphaNumeric('0'));
		$this->assertTrue(Validation::alphaNumeric('abçďĕʑʘπй'));
		$this->assertTrue(Validation::alphaNumeric('ˇˆๆゞ'));
		$this->assertTrue(Validation::alphaNumeric('אกあアꀀ豈'));
		$this->assertTrue(Validation::alphaNumeric('ǅᾈᾨ'));
		$this->assertTrue(Validation::alphaNumeric('ÆΔΩЖÇ'));


		$this->assertFalse(Validation::alphaNumeric('12 234'));
		$this->assertFalse(Validation::alphaNumeric('dfd 234'));
		$this->assertFalse(Validation::alphaNumeric("\n"));
		$this->assertFalse(Validation::alphaNumeric("\t"));
		$this->assertFalse(Validation::alphaNumeric("\r"));
		$this->assertFalse(Validation::alphaNumeric(' '));
		$this->assertFalse(Validation::alphaNumeric(''));
	}
/**
 * testAlphaNumericPassedAsArray method
 *
 * @access public
 * @return void
 */
	function testAlphaNumericPassedAsArray() {
		$this->assertTrue(Validation::alphaNumeric(array('check' => 'frferrf')));
		$this->assertTrue(Validation::alphaNumeric(array('check' => '12234')));
		$this->assertTrue(Validation::alphaNumeric(array('check' => '1w2e2r3t4y')));
		$this->assertTrue(Validation::alphaNumeric(array('check' => '0')));
		$this->assertFalse(Validation::alphaNumeric(array('check' => '12 234')));
		$this->assertFalse(Validation::alphaNumeric(array('check' => 'dfd 234')));
		$this->assertFalse(Validation::alphaNumeric(array('check' => "\n")));
		$this->assertFalse(Validation::alphaNumeric(array('check' => "\t")));
		$this->assertFalse(Validation::alphaNumeric(array('check' => "\r")));
		$this->assertFalse(Validation::alphaNumeric(array('check' =>  ' ')));
		$this->assertFalse(Validation::alphaNumeric(array('check' =>  '')));
	}
/**
 * testBetween method
 *
 * @access public
 * @return void
 */
	function testBetween() {
		$this->assertTrue(Validation::between('abcdefg', 1, 7));
		$this->assertTrue(Validation::between('', 0, 7));
		$this->assertFalse(Validation::between('abcdefg', 1, 6));
	}
/**
 * testBlank method
 *
 * @access public
 * @return void
 */
	function testBlank() {
		$this->assertTrue(Validation::blank(''));
		$this->assertTrue(Validation::blank(' '));
		$this->assertTrue(Validation::blank("\n"));
		$this->assertTrue(Validation::blank("\t"));
		$this->assertTrue(Validation::blank("\r"));
		$this->assertFalse(Validation::blank('    Blank'));
		$this->assertFalse(Validation::blank('Blank'));
	}
/**
 * testBlankAsArray method
 *
 * @access public
 * @return void
 */
	function testBlankAsArray() {
		$this->assertTrue(Validation::blank(array('check' => '')));
		$this->assertTrue(Validation::blank(array('check' => ' ')));
		$this->assertTrue(Validation::blank(array('check' => "\n")));
		$this->assertTrue(Validation::blank(array('check' => "\t")));
		$this->assertTrue(Validation::blank(array('check' => "\r")));
		$this->assertFalse(Validation::blank(array('check' => '    Blank')));
		$this->assertFalse(Validation::blank(array('check' => 'Blank')));
	}
/**
 * testcc method
 *
 * @access public
 * @return void
 */
	function testcc() {
		//American Express
		$this->assertTrue(Validation::cc('370482756063980', array('amex')));
		$this->assertTrue(Validation::cc('349106433773483', array('amex')));
		$this->assertTrue(Validation::cc('344671486204764', array('amex')));
		$this->assertTrue(Validation::cc('344042544509943', array('amex')));
		$this->assertTrue(Validation::cc('377147515754475', array('amex')));
		$this->assertTrue(Validation::cc('375239372816422', array('amex')));
		$this->assertTrue(Validation::cc('376294341957707', array('amex')));
		$this->assertTrue(Validation::cc('341779292230411', array('amex')));
		$this->assertTrue(Validation::cc('341646919853372', array('amex')));
		$this->assertTrue(Validation::cc('348498616319346', array('amex')));
		//BankCard
		$this->assertTrue(Validation::cc('5610745867413420', array('bankcard')));
		$this->assertTrue(Validation::cc('5610376649499352', array('bankcard')));
		$this->assertTrue(Validation::cc('5610091936000694', array('bankcard')));
		$this->assertTrue(Validation::cc('5602248780118788', array('bankcard')));
		$this->assertTrue(Validation::cc('5610631567676765', array('bankcard')));
		$this->assertTrue(Validation::cc('5602238211270795', array('bankcard')));
		$this->assertTrue(Validation::cc('5610173951215470', array('bankcard')));
		$this->assertTrue(Validation::cc('5610139705753702', array('bankcard')));
		$this->assertTrue(Validation::cc('5602226032150551', array('bankcard')));
		$this->assertTrue(Validation::cc('5602223993735777', array('bankcard')));
		//Diners Club 14
		$this->assertTrue(Validation::cc('30155483651028', array('diners')));
		$this->assertTrue(Validation::cc('36371312803821', array('diners')));
		$this->assertTrue(Validation::cc('38801277489875', array('diners')));
		$this->assertTrue(Validation::cc('30348560464296', array('diners')));
		$this->assertTrue(Validation::cc('30349040317708', array('diners')));
		$this->assertTrue(Validation::cc('36567413559978', array('diners')));
		$this->assertTrue(Validation::cc('36051554732702', array('diners')));
		$this->assertTrue(Validation::cc('30391842198191', array('diners')));
		$this->assertTrue(Validation::cc('30172682197745', array('diners')));
		$this->assertTrue(Validation::cc('30162056566641', array('diners')));
		$this->assertTrue(Validation::cc('30085066927745', array('diners')));
		$this->assertTrue(Validation::cc('36519025221976', array('diners')));
		$this->assertTrue(Validation::cc('30372679371044', array('diners')));
		$this->assertTrue(Validation::cc('38913939150124', array('diners')));
		$this->assertTrue(Validation::cc('36852899094637', array('diners')));
		$this->assertTrue(Validation::cc('30138041971120', array('diners')));
		$this->assertTrue(Validation::cc('36184047836838', array('diners')));
		$this->assertTrue(Validation::cc('30057460264462', array('diners')));
		$this->assertTrue(Validation::cc('38980165212050', array('diners')));
		$this->assertTrue(Validation::cc('30356516881240', array('diners')));
		$this->assertTrue(Validation::cc('38744810033182', array('diners')));
		$this->assertTrue(Validation::cc('30173638706621', array('diners')));
		$this->assertTrue(Validation::cc('30158334709185', array('diners')));
		$this->assertTrue(Validation::cc('30195413721186', array('diners')));
		$this->assertTrue(Validation::cc('38863347694793', array('diners')));
		$this->assertTrue(Validation::cc('30275627009113', array('diners')));
		$this->assertTrue(Validation::cc('30242860404971', array('diners')));
		$this->assertTrue(Validation::cc('30081877595151', array('diners')));
		$this->assertTrue(Validation::cc('38053196067461', array('diners')));
		$this->assertTrue(Validation::cc('36520379984870', array('diners')));
		//2004 MasterCard/Diners Club Alliance International 14
		$this->assertTrue(Validation::cc('36747701998969', array('diners')));
		$this->assertTrue(Validation::cc('36427861123159', array('diners')));
		$this->assertTrue(Validation::cc('36150537602386', array('diners')));
		$this->assertTrue(Validation::cc('36582388820610', array('diners')));
		$this->assertTrue(Validation::cc('36729045250216', array('diners')));
		//2004 MasterCard/Diners Club Alliance US & Canada 16
		$this->assertTrue(Validation::cc('5597511346169950', array('diners')));
		$this->assertTrue(Validation::cc('5526443162217562', array('diners')));
		$this->assertTrue(Validation::cc('5577265786122391', array('diners')));
		$this->assertTrue(Validation::cc('5534061404676989', array('diners')));
		$this->assertTrue(Validation::cc('5545313588374502', array('diners')));
		//Discover
		$this->assertTrue(Validation::cc('6011802876467237', array('disc')));
		$this->assertTrue(Validation::cc('6506432777720955', array('disc')));
		$this->assertTrue(Validation::cc('6011126265283942', array('disc')));
		$this->assertTrue(Validation::cc('6502187151579252', array('disc')));
		$this->assertTrue(Validation::cc('6506600836002298', array('disc')));
		$this->assertTrue(Validation::cc('6504376463615189', array('disc')));
		$this->assertTrue(Validation::cc('6011440907005377', array('disc')));
		$this->assertTrue(Validation::cc('6509735979634270', array('disc')));
		$this->assertTrue(Validation::cc('6011422366775856', array('disc')));
		$this->assertTrue(Validation::cc('6500976374623323', array('disc')));
		//enRoute
		$this->assertTrue(Validation::cc('201496944158937', array('enroute')));
		$this->assertTrue(Validation::cc('214945833739665', array('enroute')));
		$this->assertTrue(Validation::cc('214982692491187', array('enroute')));
		$this->assertTrue(Validation::cc('214901395949424', array('enroute')));
		$this->assertTrue(Validation::cc('201480676269187', array('enroute')));
		$this->assertTrue(Validation::cc('214911922887807', array('enroute')));
		$this->assertTrue(Validation::cc('201485025457250', array('enroute')));
		$this->assertTrue(Validation::cc('201402662758866', array('enroute')));
		$this->assertTrue(Validation::cc('214981579370225', array('enroute')));
		$this->assertTrue(Validation::cc('201447595859877', array('enroute')));
		//JCB 15 digit
		$this->assertTrue(Validation::cc('210034762247893', array('jcb')));
		$this->assertTrue(Validation::cc('180078671678892', array('jcb')));
		$this->assertTrue(Validation::cc('180010559353736', array('jcb')));
		$this->assertTrue(Validation::cc('210095474464258', array('jcb')));
		$this->assertTrue(Validation::cc('210006675562188', array('jcb')));
		$this->assertTrue(Validation::cc('210063299662662', array('jcb')));
		$this->assertTrue(Validation::cc('180032506857825', array('jcb')));
		$this->assertTrue(Validation::cc('210057919192738', array('jcb')));
		$this->assertTrue(Validation::cc('180031358949367', array('jcb')));
		$this->assertTrue(Validation::cc('180033802147846', array('jcb')));
		//JCB 16 digit
		$this->assertTrue(Validation::cc('3096806857839939', array('jcb')));
		$this->assertTrue(Validation::cc('3158699503187091', array('jcb')));
		$this->assertTrue(Validation::cc('3112549607186579', array('jcb')));
		$this->assertTrue(Validation::cc('3112332922425604', array('jcb')));
		$this->assertTrue(Validation::cc('3112001541159239', array('jcb')));
		$this->assertTrue(Validation::cc('3112162495317841', array('jcb')));
		$this->assertTrue(Validation::cc('3337562627732768', array('jcb')));
		$this->assertTrue(Validation::cc('3337107161330775', array('jcb')));
		$this->assertTrue(Validation::cc('3528053736003621', array('jcb')));
		$this->assertTrue(Validation::cc('3528915255020360', array('jcb')));
		$this->assertTrue(Validation::cc('3096786059660921', array('jcb')));
		$this->assertTrue(Validation::cc('3528264799292320', array('jcb')));
		$this->assertTrue(Validation::cc('3096469164130136', array('jcb')));
		$this->assertTrue(Validation::cc('3112127443822853', array('jcb')));
		$this->assertTrue(Validation::cc('3096849995802328', array('jcb')));
		$this->assertTrue(Validation::cc('3528090735127407', array('jcb')));
		$this->assertTrue(Validation::cc('3112101006819234', array('jcb')));
		$this->assertTrue(Validation::cc('3337444428040784', array('jcb')));
		$this->assertTrue(Validation::cc('3088043154151061', array('jcb')));
		$this->assertTrue(Validation::cc('3088295969414866', array('jcb')));
		$this->assertTrue(Validation::cc('3158748843158575', array('jcb')));
		$this->assertTrue(Validation::cc('3158709206148538', array('jcb')));
		$this->assertTrue(Validation::cc('3158365159575324', array('jcb')));
		$this->assertTrue(Validation::cc('3158671691305165', array('jcb')));
		$this->assertTrue(Validation::cc('3528523028771093', array('jcb')));
		$this->assertTrue(Validation::cc('3096057126267870', array('jcb')));
		$this->assertTrue(Validation::cc('3158514047166834', array('jcb')));
		$this->assertTrue(Validation::cc('3528274546125962', array('jcb')));
		$this->assertTrue(Validation::cc('3528890967705733', array('jcb')));
		$this->assertTrue(Validation::cc('3337198811307545', array('jcb')));
		//Maestro (debit card)
		$this->assertTrue(Validation::cc('5020147409985219', array('maestro')));
		$this->assertTrue(Validation::cc('5020931809905616', array('maestro')));
		$this->assertTrue(Validation::cc('5020412965470224', array('maestro')));
		$this->assertTrue(Validation::cc('5020129740944022', array('maestro')));
		$this->assertTrue(Validation::cc('5020024696747943', array('maestro')));
		$this->assertTrue(Validation::cc('5020581514636509', array('maestro')));
		$this->assertTrue(Validation::cc('5020695008411987', array('maestro')));
		$this->assertTrue(Validation::cc('5020565359718977', array('maestro')));
		$this->assertTrue(Validation::cc('6339931536544062', array('maestro')));
		$this->assertTrue(Validation::cc('6465028615704406', array('maestro')));
		//Mastercard
		$this->assertTrue(Validation::cc('5580424361774366', array('mc')));
		$this->assertTrue(Validation::cc('5589563059318282', array('mc')));
		$this->assertTrue(Validation::cc('5387558333690047', array('mc')));
		$this->assertTrue(Validation::cc('5163919215247175', array('mc')));
		$this->assertTrue(Validation::cc('5386742685055055', array('mc')));
		$this->assertTrue(Validation::cc('5102303335960674', array('mc')));
		$this->assertTrue(Validation::cc('5526543403964565', array('mc')));
		$this->assertTrue(Validation::cc('5538725892618432', array('mc')));
		$this->assertTrue(Validation::cc('5119543573129778', array('mc')));
		$this->assertTrue(Validation::cc('5391174753915767', array('mc')));
		$this->assertTrue(Validation::cc('5510994113980714', array('mc')));
		$this->assertTrue(Validation::cc('5183720260418091', array('mc')));
		$this->assertTrue(Validation::cc('5488082196086704', array('mc')));
		$this->assertTrue(Validation::cc('5484645164161834', array('mc')));
		$this->assertTrue(Validation::cc('5171254350337031', array('mc')));
		$this->assertTrue(Validation::cc('5526987528136452', array('mc')));
		$this->assertTrue(Validation::cc('5504148941409358', array('mc')));
		$this->assertTrue(Validation::cc('5240793507243615', array('mc')));
		$this->assertTrue(Validation::cc('5162114693017107', array('mc')));
		$this->assertTrue(Validation::cc('5163104807404753', array('mc')));
		$this->assertTrue(Validation::cc('5590136167248365', array('mc')));
		$this->assertTrue(Validation::cc('5565816281038948', array('mc')));
		$this->assertTrue(Validation::cc('5467639122779531', array('mc')));
		$this->assertTrue(Validation::cc('5297350261550024', array('mc')));
		$this->assertTrue(Validation::cc('5162739131368058', array('mc')));
		//Solo 16
		$this->assertTrue(Validation::cc('6767432107064987', array('solo')));
		$this->assertTrue(Validation::cc('6334667758225411', array('solo')));
		$this->assertTrue(Validation::cc('6767037421954068', array('solo')));
		$this->assertTrue(Validation::cc('6767823306394854', array('solo')));
		$this->assertTrue(Validation::cc('6334768185398134', array('solo')));
		$this->assertTrue(Validation::cc('6767286729498589', array('solo')));
		$this->assertTrue(Validation::cc('6334972104431261', array('solo')));
		$this->assertTrue(Validation::cc('6334843427400616', array('solo')));
		$this->assertTrue(Validation::cc('6767493947881311', array('solo')));
		$this->assertTrue(Validation::cc('6767194235798817', array('solo')));
		//Solo 18
		$this->assertTrue(Validation::cc('676714834398858593', array('solo')));
		$this->assertTrue(Validation::cc('676751666435130857', array('solo')));
		$this->assertTrue(Validation::cc('676781908573924236', array('solo')));
		$this->assertTrue(Validation::cc('633488724644003240', array('solo')));
		$this->assertTrue(Validation::cc('676732252338067316', array('solo')));
		$this->assertTrue(Validation::cc('676747520084495821', array('solo')));
		$this->assertTrue(Validation::cc('633465488901381957', array('solo')));
		$this->assertTrue(Validation::cc('633487484858610484', array('solo')));
		$this->assertTrue(Validation::cc('633453764680740694', array('solo')));
		$this->assertTrue(Validation::cc('676768613295414451', array('solo')));
		//Solo 19
		$this->assertTrue(Validation::cc('6767838565218340113', array('solo')));
		$this->assertTrue(Validation::cc('6767760119829705181', array('solo')));
		$this->assertTrue(Validation::cc('6767265917091593668', array('solo')));
		$this->assertTrue(Validation::cc('6767938856947440111', array('solo')));
		$this->assertTrue(Validation::cc('6767501945697390076', array('solo')));
		$this->assertTrue(Validation::cc('6334902868716257379', array('solo')));
		$this->assertTrue(Validation::cc('6334922127686425532', array('solo')));
		$this->assertTrue(Validation::cc('6334933119080706440', array('solo')));
		$this->assertTrue(Validation::cc('6334647959628261714', array('solo')));
		$this->assertTrue(Validation::cc('6334527312384101382', array('solo')));
		//Switch 16
		$this->assertTrue(Validation::cc('5641829171515733', array('switch')));
		$this->assertTrue(Validation::cc('5641824852820809', array('switch')));
		$this->assertTrue(Validation::cc('6759129648956909', array('switch')));
		$this->assertTrue(Validation::cc('6759626072268156', array('switch')));
		$this->assertTrue(Validation::cc('5641822698388957', array('switch')));
		$this->assertTrue(Validation::cc('5641827123105470', array('switch')));
		$this->assertTrue(Validation::cc('5641823755819553', array('switch')));
		$this->assertTrue(Validation::cc('5641821939587682', array('switch')));
		$this->assertTrue(Validation::cc('4936097148079186', array('switch')));
		$this->assertTrue(Validation::cc('5641829739125009', array('switch')));
		$this->assertTrue(Validation::cc('5641822860725507', array('switch')));
		$this->assertTrue(Validation::cc('4936717688865831', array('switch')));
		$this->assertTrue(Validation::cc('6759487613615441', array('switch')));
		$this->assertTrue(Validation::cc('5641821346840617', array('switch')));
		$this->assertTrue(Validation::cc('5641825793417126', array('switch')));
		$this->assertTrue(Validation::cc('5641821302759595', array('switch')));
		$this->assertTrue(Validation::cc('6759784969918837', array('switch')));
		$this->assertTrue(Validation::cc('5641824910667036', array('switch')));
		$this->assertTrue(Validation::cc('6759139909636173', array('switch')));
		$this->assertTrue(Validation::cc('6333425070638022', array('switch')));
		$this->assertTrue(Validation::cc('5641823910382067', array('switch')));
		$this->assertTrue(Validation::cc('4936295218139423', array('switch')));
		$this->assertTrue(Validation::cc('6333031811316199', array('switch')));
		$this->assertTrue(Validation::cc('4936912044763198', array('switch')));
		$this->assertTrue(Validation::cc('4936387053303824', array('switch')));
		$this->assertTrue(Validation::cc('6759535838760523', array('switch')));
		$this->assertTrue(Validation::cc('6333427174594051', array('switch')));
		$this->assertTrue(Validation::cc('5641829037102700', array('switch')));
		$this->assertTrue(Validation::cc('5641826495463046', array('switch')));
		$this->assertTrue(Validation::cc('6333480852979946', array('switch')));
		$this->assertTrue(Validation::cc('5641827761302876', array('switch')));
		$this->assertTrue(Validation::cc('5641825083505317', array('switch')));
		$this->assertTrue(Validation::cc('6759298096003991', array('switch')));
		$this->assertTrue(Validation::cc('4936119165483420', array('switch')));
		$this->assertTrue(Validation::cc('4936190990500993', array('switch')));
		$this->assertTrue(Validation::cc('4903356467384927', array('switch')));
		$this->assertTrue(Validation::cc('6333372765092554', array('switch')));
		$this->assertTrue(Validation::cc('5641821330950570', array('switch')));
		$this->assertTrue(Validation::cc('6759841558826118', array('switch')));
		$this->assertTrue(Validation::cc('4936164540922452', array('switch')));
		//Switch 18
		$this->assertTrue(Validation::cc('493622764224625174', array('switch')));
		$this->assertTrue(Validation::cc('564182823396913535', array('switch')));
		$this->assertTrue(Validation::cc('675917308304801234', array('switch')));
		$this->assertTrue(Validation::cc('675919890024220298', array('switch')));
		$this->assertTrue(Validation::cc('633308376862556751', array('switch')));
		$this->assertTrue(Validation::cc('564182377633208779', array('switch')));
		$this->assertTrue(Validation::cc('564182870014926787', array('switch')));
		$this->assertTrue(Validation::cc('675979788553829819', array('switch')));
		$this->assertTrue(Validation::cc('493668394358130935', array('switch')));
		$this->assertTrue(Validation::cc('493637431790930965', array('switch')));
		$this->assertTrue(Validation::cc('633321438601941513', array('switch')));
		$this->assertTrue(Validation::cc('675913800898840986', array('switch')));
		$this->assertTrue(Validation::cc('564182592016841547', array('switch')));
		$this->assertTrue(Validation::cc('564182428380440899', array('switch')));
		$this->assertTrue(Validation::cc('493696376827623463', array('switch')));
		$this->assertTrue(Validation::cc('675977939286485757', array('switch')));
		$this->assertTrue(Validation::cc('490302699502091579', array('switch')));
		$this->assertTrue(Validation::cc('564182085013662230', array('switch')));
		$this->assertTrue(Validation::cc('493693054263310167', array('switch')));
		$this->assertTrue(Validation::cc('633321755966697525', array('switch')));
		$this->assertTrue(Validation::cc('675996851719732811', array('switch')));
		$this->assertTrue(Validation::cc('493699211208281028', array('switch')));
		$this->assertTrue(Validation::cc('493697817378356614', array('switch')));
		$this->assertTrue(Validation::cc('675968224161768150', array('switch')));
		$this->assertTrue(Validation::cc('493669416873337627', array('switch')));
		$this->assertTrue(Validation::cc('564182439172549714', array('switch')));
		$this->assertTrue(Validation::cc('675926914467673598', array('switch')));
		$this->assertTrue(Validation::cc('564182565231977809', array('switch')));
		$this->assertTrue(Validation::cc('675966282607849002', array('switch')));
		$this->assertTrue(Validation::cc('493691609704348548', array('switch')));
		$this->assertTrue(Validation::cc('675933118546065120', array('switch')));
		$this->assertTrue(Validation::cc('493631116677238592', array('switch')));
		$this->assertTrue(Validation::cc('675921142812825938', array('switch')));
		$this->assertTrue(Validation::cc('633338311815675113', array('switch')));
		$this->assertTrue(Validation::cc('633323539867338621', array('switch')));
		$this->assertTrue(Validation::cc('675964912740845663', array('switch')));
		$this->assertTrue(Validation::cc('633334008833727504', array('switch')));
		$this->assertTrue(Validation::cc('493631941273687169', array('switch')));
		$this->assertTrue(Validation::cc('564182971729706785', array('switch')));
		$this->assertTrue(Validation::cc('633303461188963496', array('switch')));
		//Switch 19
		$this->assertTrue(Validation::cc('6759603460617628716', array('switch')));
		$this->assertTrue(Validation::cc('4936705825268647681', array('switch')));
		$this->assertTrue(Validation::cc('5641829846600479183', array('switch')));
		$this->assertTrue(Validation::cc('6759389846573792530', array('switch')));
		$this->assertTrue(Validation::cc('4936189558712637603', array('switch')));
		$this->assertTrue(Validation::cc('5641822217393868189', array('switch')));
		$this->assertTrue(Validation::cc('4903075563780057152', array('switch')));
		$this->assertTrue(Validation::cc('4936510653566569547', array('switch')));
		$this->assertTrue(Validation::cc('4936503083627303364', array('switch')));
		$this->assertTrue(Validation::cc('4936777334398116272', array('switch')));
		$this->assertTrue(Validation::cc('5641823876900554860', array('switch')));
		$this->assertTrue(Validation::cc('6759619236903407276', array('switch')));
		$this->assertTrue(Validation::cc('6759011470269978117', array('switch')));
		$this->assertTrue(Validation::cc('6333175833997062502', array('switch')));
		$this->assertTrue(Validation::cc('6759498728789080439', array('switch')));
		$this->assertTrue(Validation::cc('4903020404168157841', array('switch')));
		$this->assertTrue(Validation::cc('6759354334874804313', array('switch')));
		$this->assertTrue(Validation::cc('6759900856420875115', array('switch')));
		$this->assertTrue(Validation::cc('5641827269346868860', array('switch')));
		$this->assertTrue(Validation::cc('5641828995047453870', array('switch')));
		$this->assertTrue(Validation::cc('6333321884754806543', array('switch')));
		$this->assertTrue(Validation::cc('6333108246283715901', array('switch')));
		$this->assertTrue(Validation::cc('6759572372800700102', array('switch')));
		$this->assertTrue(Validation::cc('4903095096797974933', array('switch')));
		$this->assertTrue(Validation::cc('6333354315797920215', array('switch')));
		$this->assertTrue(Validation::cc('6759163746089433755', array('switch')));
		$this->assertTrue(Validation::cc('6759871666634807647', array('switch')));
		$this->assertTrue(Validation::cc('5641827883728575248', array('switch')));
		$this->assertTrue(Validation::cc('4936527975051407847', array('switch')));
		$this->assertTrue(Validation::cc('5641823318396882141', array('switch')));
		$this->assertTrue(Validation::cc('6759123772311123708', array('switch')));
		$this->assertTrue(Validation::cc('4903054736148271088', array('switch')));
		$this->assertTrue(Validation::cc('4936477526808883952', array('switch')));
		$this->assertTrue(Validation::cc('4936433964890967966', array('switch')));
		$this->assertTrue(Validation::cc('6333245128906049344', array('switch')));
		$this->assertTrue(Validation::cc('4936321036970553134', array('switch')));
		$this->assertTrue(Validation::cc('4936111816358702773', array('switch')));
		$this->assertTrue(Validation::cc('4936196077254804290', array('switch')));
		$this->assertTrue(Validation::cc('6759558831206830183', array('switch')));
		$this->assertTrue(Validation::cc('5641827998830403137', array('switch')));
		//VISA 13 digit
		$this->assertTrue(Validation::cc('4024007174754', array('visa')));
		$this->assertTrue(Validation::cc('4104816460717', array('visa')));
		$this->assertTrue(Validation::cc('4716229700437', array('visa')));
		$this->assertTrue(Validation::cc('4539305400213', array('visa')));
		$this->assertTrue(Validation::cc('4728260558665', array('visa')));
		$this->assertTrue(Validation::cc('4929100131792', array('visa')));
		$this->assertTrue(Validation::cc('4024007117308', array('visa')));
		$this->assertTrue(Validation::cc('4539915491024', array('visa')));
		$this->assertTrue(Validation::cc('4539790901139', array('visa')));
		$this->assertTrue(Validation::cc('4485284914909', array('visa')));
		$this->assertTrue(Validation::cc('4782793022350', array('visa')));
		$this->assertTrue(Validation::cc('4556899290685', array('visa')));
		$this->assertTrue(Validation::cc('4024007134774', array('visa')));
		$this->assertTrue(Validation::cc('4333412341316', array('visa')));
		$this->assertTrue(Validation::cc('4539534204543', array('visa')));
		$this->assertTrue(Validation::cc('4485640373626', array('visa')));
		$this->assertTrue(Validation::cc('4929911445746', array('visa')));
		$this->assertTrue(Validation::cc('4539292550806', array('visa')));
		$this->assertTrue(Validation::cc('4716523014030', array('visa')));
		$this->assertTrue(Validation::cc('4024007125152', array('visa')));
		$this->assertTrue(Validation::cc('4539758883311', array('visa')));
		$this->assertTrue(Validation::cc('4024007103258', array('visa')));
		$this->assertTrue(Validation::cc('4916933155767', array('visa')));
		$this->assertTrue(Validation::cc('4024007159672', array('visa')));
		$this->assertTrue(Validation::cc('4716935544871', array('visa')));
		$this->assertTrue(Validation::cc('4929415177779', array('visa')));
		$this->assertTrue(Validation::cc('4929748547896', array('visa')));
		$this->assertTrue(Validation::cc('4929153468612', array('visa')));
		$this->assertTrue(Validation::cc('4539397132104', array('visa')));
		$this->assertTrue(Validation::cc('4485293435540', array('visa')));
		$this->assertTrue(Validation::cc('4485799412720', array('visa')));
		$this->assertTrue(Validation::cc('4916744757686', array('visa')));
		$this->assertTrue(Validation::cc('4556475655426', array('visa')));
		$this->assertTrue(Validation::cc('4539400441625', array('visa')));
		$this->assertTrue(Validation::cc('4485437129173', array('visa')));
		$this->assertTrue(Validation::cc('4716253605320', array('visa')));
		$this->assertTrue(Validation::cc('4539366156589', array('visa')));
		$this->assertTrue(Validation::cc('4916498061392', array('visa')));
		$this->assertTrue(Validation::cc('4716127163779', array('visa')));
		$this->assertTrue(Validation::cc('4024007183078', array('visa')));
		$this->assertTrue(Validation::cc('4041553279654', array('visa')));
		$this->assertTrue(Validation::cc('4532380121960', array('visa')));
		$this->assertTrue(Validation::cc('4485906062491', array('visa')));
		$this->assertTrue(Validation::cc('4539365115149', array('visa')));
		$this->assertTrue(Validation::cc('4485146516702', array('visa')));
		//VISA 16 digit
		$this->assertTrue(Validation::cc('4916375389940009', array('visa')));
		$this->assertTrue(Validation::cc('4929167481032610', array('visa')));
		$this->assertTrue(Validation::cc('4485029969061519', array('visa')));
		$this->assertTrue(Validation::cc('4485573845281759', array('visa')));
		$this->assertTrue(Validation::cc('4485669810383529', array('visa')));
		$this->assertTrue(Validation::cc('4929615806560327', array('visa')));
		$this->assertTrue(Validation::cc('4556807505609535', array('visa')));
		$this->assertTrue(Validation::cc('4532611336232890', array('visa')));
		$this->assertTrue(Validation::cc('4532201952422387', array('visa')));
		$this->assertTrue(Validation::cc('4485073797976290', array('visa')));
		$this->assertTrue(Validation::cc('4024007157580969', array('visa')));
		$this->assertTrue(Validation::cc('4053740470212274', array('visa')));
		$this->assertTrue(Validation::cc('4716265831525676', array('visa')));
		$this->assertTrue(Validation::cc('4024007100222966', array('visa')));
		$this->assertTrue(Validation::cc('4539556148303244', array('visa')));
		$this->assertTrue(Validation::cc('4532449879689709', array('visa')));
		$this->assertTrue(Validation::cc('4916805467840986', array('visa')));
		$this->assertTrue(Validation::cc('4532155644440233', array('visa')));
		$this->assertTrue(Validation::cc('4467977802223781', array('visa')));
		$this->assertTrue(Validation::cc('4539224637000686', array('visa')));
		$this->assertTrue(Validation::cc('4556629187064965', array('visa')));
		$this->assertTrue(Validation::cc('4532970205932943', array('visa')));
		$this->assertTrue(Validation::cc('4821470132041850', array('visa')));
		$this->assertTrue(Validation::cc('4916214267894485', array('visa')));
		$this->assertTrue(Validation::cc('4024007169073284', array('visa')));
		$this->assertTrue(Validation::cc('4716783351296122', array('visa')));
		$this->assertTrue(Validation::cc('4556480171913795', array('visa')));
		$this->assertTrue(Validation::cc('4929678411034997', array('visa')));
		$this->assertTrue(Validation::cc('4682061913519392', array('visa')));
		$this->assertTrue(Validation::cc('4916495481746474', array('visa')));
		$this->assertTrue(Validation::cc('4929007108460499', array('visa')));
		$this->assertTrue(Validation::cc('4539951357838586', array('visa')));
		$this->assertTrue(Validation::cc('4716482691051558', array('visa')));
		$this->assertTrue(Validation::cc('4916385069917516', array('visa')));
		$this->assertTrue(Validation::cc('4929020289494641', array('visa')));
		$this->assertTrue(Validation::cc('4532176245263774', array('visa')));
		$this->assertTrue(Validation::cc('4556242273553949', array('visa')));
		$this->assertTrue(Validation::cc('4481007485188614', array('visa')));
		$this->assertTrue(Validation::cc('4716533372139623', array('visa')));
		$this->assertTrue(Validation::cc('4929152038152632', array('visa')));
		$this->assertTrue(Validation::cc('4539404037310550', array('visa')));
		$this->assertTrue(Validation::cc('4532800925229140', array('visa')));
		$this->assertTrue(Validation::cc('4916845885268360', array('visa')));
		$this->assertTrue(Validation::cc('4394514669078434', array('visa')));
		$this->assertTrue(Validation::cc('4485611378115042', array('visa')));
		//Visa Electron
		$this->assertTrue(Validation::cc('4175003346287100', array('electron')));
		$this->assertTrue(Validation::cc('4913042516577228', array('electron')));
		$this->assertTrue(Validation::cc('4917592325659381', array('electron')));
		$this->assertTrue(Validation::cc('4917084924450511', array('electron')));
		$this->assertTrue(Validation::cc('4917994610643999', array('electron')));
		$this->assertTrue(Validation::cc('4175005933743585', array('electron')));
		$this->assertTrue(Validation::cc('4175008373425044', array('electron')));
		$this->assertTrue(Validation::cc('4913119763664154', array('electron')));
		$this->assertTrue(Validation::cc('4913189017481812', array('electron')));
		$this->assertTrue(Validation::cc('4913085104968622', array('electron')));
		$this->assertTrue(Validation::cc('4175008803122021', array('electron')));
		$this->assertTrue(Validation::cc('4913294453962489', array('electron')));
		$this->assertTrue(Validation::cc('4175009797419290', array('electron')));
		$this->assertTrue(Validation::cc('4175005028142917', array('electron')));
		$this->assertTrue(Validation::cc('4913940802385364', array('electron')));
		//Voyager
		$this->assertTrue(Validation::cc('869940697287073', array('voyager')));
		$this->assertTrue(Validation::cc('869934523596112', array('voyager')));
		$this->assertTrue(Validation::cc('869958670174621', array('voyager')));
		$this->assertTrue(Validation::cc('869921250068209', array('voyager')));
		$this->assertTrue(Validation::cc('869972521242198', array('voyager')));
	}
/**
 * testLuhn method
 *
 * @access public
 * @return void
 */
	function testLuhn() {
		$this->Validation->deep = true;

		//American Express
		$this->Validation->check = '370482756063980';
		$this->assertTrue($this->Validation->_luhn());
		//BankCard
		$this->Validation->check = '5610745867413420';
		$this->assertTrue($this->Validation->_luhn());
		//Diners Club 14
		$this->Validation->check = '30155483651028';
		$this->assertTrue($this->Validation->_luhn());
		//2004 MasterCard/Diners Club Alliance International 14
		$this->Validation->check = '36747701998969';
		$this->assertTrue($this->Validation->_luhn());
		//2004 MasterCard/Diners Club Alliance US & Canada 16
		$this->Validation->check = '5597511346169950';
		$this->assertTrue($this->Validation->_luhn());
		//Discover
		$this->Validation->check = '6011802876467237';
		$this->assertTrue($this->Validation->_luhn());
		//enRoute
		$this->Validation->check = '201496944158937';
		$this->assertTrue($this->Validation->_luhn());
		//JCB 15 digit
		$this->Validation->check = '210034762247893';
		$this->assertTrue($this->Validation->_luhn());
		//JCB 16 digit
		$this->Validation->check = '3096806857839939';
		$this->assertTrue($this->Validation->_luhn());
		//Maestro (debit card)
		$this->Validation->check = '5020147409985219';
		$this->assertTrue($this->Validation->_luhn());
		//Mastercard
		$this->Validation->check = '5580424361774366';
		$this->assertTrue($this->Validation->_luhn());
		//Solo 16
		$this->Validation->check = '6767432107064987';
		$this->assertTrue($this->Validation->_luhn());
		//Solo 18
		$this->Validation->check = '676714834398858593';
		$this->assertTrue($this->Validation->_luhn());
		//Solo 19
		$this->Validation->check = '6767838565218340113';
		$this->assertTrue($this->Validation->_luhn());
		//Switch 16
		$this->Validation->check = '5641829171515733';
		$this->assertTrue($this->Validation->_luhn());
		//Switch 18
		$this->Validation->check = '493622764224625174';
		$this->assertTrue($this->Validation->_luhn());
		//Switch 19
		$this->Validation->check = '6759603460617628716';
		$this->assertTrue($this->Validation->_luhn());
		//VISA 13 digit
		$this->Validation->check = '4024007174754';
		$this->assertTrue($this->Validation->_luhn());
		//VISA 16 digit
		$this->Validation->check = '4916375389940009';
		$this->assertTrue($this->Validation->_luhn());
		//Visa Electron
		$this->Validation->check = '4175003346287100';
		$this->assertTrue($this->Validation->_luhn());
		//Voyager
		$this->Validation->check = '869940697287073';
		$this->assertTrue($this->Validation->_luhn());

		$this->Validation->check = '0000000000000000';
		$this->assertFalse($this->Validation->_luhn());

		$this->Validation->check = '869940697287173';
		$this->assertFalse($this->Validation->_luhn());
	}
/**
 * testCustomRegexForCc method
 *
 * @access public
 * @return void
 */
	function testCustomRegexForCc() {
		$this->assertTrue(Validation::cc('12332105933743585', null, null, '/123321\\d{11}/'));
		$this->assertFalse(Validation::cc('1233210593374358', null, null, '/123321\\d{11}/'));
		$this->assertFalse(Validation::cc('12312305933743585', null, null, '/123321\\d{11}/'));
	}
/**
 * testCustomRegexForCcWithLuhnCheck method
 *
 * @access public
 * @return void
 */
	function testCustomRegexForCcWithLuhnCheck() {
		$this->assertTrue(Validation::cc('12332110426226941', null, true, '/123321\\d{11}/'));
		$this->assertFalse(Validation::cc('12332105933743585', null, true, '/123321\\d{11}/'));
		$this->assertFalse(Validation::cc('12332105933743587', null, true, '/123321\\d{11}/'));
		$this->assertFalse(Validation::cc('12312305933743585', null, true, '/123321\\d{11}/'));
	}
/**
 * testFastCc method
 *
 * @access public
 * @return void
 */
	function testFastCc() {
		// too short
		$this->assertFalse(Validation::cc('123456789012'));
		//American Express
		$this->assertTrue(Validation::cc('370482756063980'));
		//Diners Club 14
		$this->assertTrue(Validation::cc('30155483651028'));
		//2004 MasterCard/Diners Club Alliance International 14
		$this->assertTrue(Validation::cc('36747701998969'));
		//2004 MasterCard/Diners Club Alliance US & Canada 16
		$this->assertTrue(Validation::cc('5597511346169950'));
		//Discover
		$this->assertTrue(Validation::cc('6011802876467237'));
		//Mastercard
		$this->assertTrue(Validation::cc('5580424361774366'));
		//VISA 13 digit
		$this->assertTrue(Validation::cc('4024007174754'));
		//VISA 16 digit
		$this->assertTrue(Validation::cc('4916375389940009'));
		//Visa Electron
		$this->assertTrue(Validation::cc('4175003346287100'));
	}
/**
 * testAllCc method
 *
 * @access public
 * @return void
 */
	function testAllCc() {
		//American Express
		$this->assertTrue(Validation::cc('370482756063980', 'all'));
		//BankCard
		$this->assertTrue(Validation::cc('5610745867413420', 'all'));
		//Diners Club 14
		$this->assertTrue(Validation::cc('30155483651028', 'all'));
		//2004 MasterCard/Diners Club Alliance International 14
		$this->assertTrue(Validation::cc('36747701998969', 'all'));
		//2004 MasterCard/Diners Club Alliance US & Canada 16
		$this->assertTrue(Validation::cc('5597511346169950', 'all'));
		//Discover
		$this->assertTrue(Validation::cc('6011802876467237', 'all'));
		//enRoute
		$this->assertTrue(Validation::cc('201496944158937', 'all'));
		//JCB 15 digit
		$this->assertTrue(Validation::cc('210034762247893', 'all'));
		//JCB 16 digit
		$this->assertTrue(Validation::cc('3096806857839939', 'all'));
		//Maestro (debit card)
		$this->assertTrue(Validation::cc('5020147409985219', 'all'));
		//Mastercard
		$this->assertTrue(Validation::cc('5580424361774366', 'all'));
		//Solo 16
		$this->assertTrue(Validation::cc('6767432107064987', 'all'));
		//Solo 18
		$this->assertTrue(Validation::cc('676714834398858593', 'all'));
		//Solo 19
		$this->assertTrue(Validation::cc('6767838565218340113', 'all'));
		//Switch 16
		$this->assertTrue(Validation::cc('5641829171515733', 'all'));
		//Switch 18
		$this->assertTrue(Validation::cc('493622764224625174', 'all'));
		//Switch 19
		$this->assertTrue(Validation::cc('6759603460617628716', 'all'));
		//VISA 13 digit
		$this->assertTrue(Validation::cc('4024007174754', 'all'));
		//VISA 16 digit
		$this->assertTrue(Validation::cc('4916375389940009', 'all'));
		//Visa Electron
		$this->assertTrue(Validation::cc('4175003346287100', 'all'));
		//Voyager
		$this->assertTrue(Validation::cc('869940697287073', 'all'));
	}
/**
 * testAllCcDeep method
 *
 * @access public
 * @return void
 */
	function testAllCcDeep() {
		//American Express
		$this->assertTrue(Validation::cc('370482756063980', 'all', true));
		//BankCard
		$this->assertTrue(Validation::cc('5610745867413420', 'all', true));
		//Diners Club 14
		$this->assertTrue(Validation::cc('30155483651028', 'all', true));
		//2004 MasterCard/Diners Club Alliance International 14
		$this->assertTrue(Validation::cc('36747701998969', 'all', true));
		//2004 MasterCard/Diners Club Alliance US & Canada 16
		$this->assertTrue(Validation::cc('5597511346169950', 'all', true));
		//Discover
		$this->assertTrue(Validation::cc('6011802876467237', 'all', true));
		//enRoute
		$this->assertTrue(Validation::cc('201496944158937', 'all', true));
		//JCB 15 digit
		$this->assertTrue(Validation::cc('210034762247893', 'all', true));
		//JCB 16 digit
		$this->assertTrue(Validation::cc('3096806857839939', 'all', true));
		//Maestro (debit card)
		$this->assertTrue(Validation::cc('5020147409985219', 'all', true));
		//Mastercard
		$this->assertTrue(Validation::cc('5580424361774366', 'all', true));
		//Solo 16
		$this->assertTrue(Validation::cc('6767432107064987', 'all', true));
		//Solo 18
		$this->assertTrue(Validation::cc('676714834398858593', 'all', true));
		//Solo 19
		$this->assertTrue(Validation::cc('6767838565218340113', 'all', true));
		//Switch 16
		$this->assertTrue(Validation::cc('5641829171515733', 'all', true));
		//Switch 18
		$this->assertTrue(Validation::cc('493622764224625174', 'all', true));
		//Switch 19
		$this->assertTrue(Validation::cc('6759603460617628716', 'all', true));
		//VISA 13 digit
		$this->assertTrue(Validation::cc('4024007174754', 'all', true));
		//VISA 16 digit
		$this->assertTrue(Validation::cc('4916375389940009', 'all', true));
		//Visa Electron
		$this->assertTrue(Validation::cc('4175003346287100', 'all', true));
		//Voyager
		$this->assertTrue(Validation::cc('869940697287073', 'all', true));
	}
/**
 * testComparison method
 *
 * @access public
 * @return void
 */
	function testComparison() {
		$this->assertFalse(Validation::comparison(7, null, 6));
		$this->assertTrue(Validation::comparison(7, 'is greater', 6));
		$this->assertTrue(Validation::comparison(7, '>', 6));
		$this->assertTrue(Validation::comparison(6, 'is less', 7));
		$this->assertTrue(Validation::comparison(6, '<', 7));
		$this->assertTrue(Validation::comparison(7, 'greater or equal', 7));
		$this->assertTrue(Validation::comparison(7, '>=', 7));
		$this->assertTrue(Validation::comparison(7, 'greater or equal', 6));
		$this->assertTrue(Validation::comparison(7, '>=', 6));
		$this->assertTrue(Validation::comparison(6, 'less or equal', 7));
		$this->assertTrue(Validation::comparison(6, '<=', 7));
		$this->assertTrue(Validation::comparison(7, 'equal to', 7));
		$this->assertTrue(Validation::comparison(7, '==', 7));
		$this->assertTrue(Validation::comparison(7, 'not equal', 6));
		$this->assertTrue(Validation::comparison(7, '!=', 6));
		$this->assertFalse(Validation::comparison(6, 'is greater', 7));
		$this->assertFalse(Validation::comparison(6, '>', 7));
		$this->assertFalse(Validation::comparison(7, 'is less', 6));
		$this->assertFalse(Validation::comparison(7, '<', 6));
		$this->assertFalse(Validation::comparison(6, 'greater or equal', 7));
		$this->assertFalse(Validation::comparison(6, '>=', 7));
		$this->assertFalse(Validation::comparison(6, 'greater or equal', 7));
		$this->assertFalse(Validation::comparison(6, '>=', 7));
		$this->assertFalse(Validation::comparison(7, 'less or equal', 6));
		$this->assertFalse(Validation::comparison(7, '<=', 6));
		$this->assertFalse(Validation::comparison(7, 'equal to', 6));
		$this->assertFalse(Validation::comparison(7, '==', 6));
		$this->assertFalse(Validation::comparison(7, 'not equal', 7));
		$this->assertFalse(Validation::comparison(7, '!=', 7));
	}
/**
 * testComparisonAsArray method
 *
 * @access public
 * @return void
 */
	function testComparisonAsArray() {
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => 'is greater', 'check2' => 6)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => '>', 'check2' => 6)));
		$this->assertTrue(Validation::comparison(array('check1' => 6, 'operator' => 'is less', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 6, 'operator' => '<', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => 'greater or equal', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => '>=', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => 'greater or equal','check2' =>  6)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => '>=', 'check2' => 6)));
		$this->assertTrue(Validation::comparison(array('check1' => 6, 'operator' => 'less or equal', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 6, 'operator' => '<=', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => 'equal to', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => '==', 'check2' => 7)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => 'not equal', 'check2' => 6)));
		$this->assertTrue(Validation::comparison(array('check1' => 7, 'operator' => '!=', 'check2' => 6)));
		$this->assertFalse(Validation::comparison(array('check1' => 6, 'operator' => 'is greater', 'check2' => 7)));
		$this->assertFalse(Validation::comparison(array('check1' => 6, 'operator' => '>', 'check2' => 7)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => 'is less', 'check2' => 6)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => '<', 'check2' => 6)));
		$this->assertFalse(Validation::comparison(array('check1' => 6, 'operator' => 'greater or equal', 'check2' => 7)));
		$this->assertFalse(Validation::comparison(array('check1' => 6, 'operator' => '>=', 'check2' => 7)));
		$this->assertFalse(Validation::comparison(array('check1' => 6, 'operator' => 'greater or equal', 'check2' => 7)));
		$this->assertFalse(Validation::comparison(array('check1' => 6, 'operator' => '>=', 'check2' => 7)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => 'less or equal', 'check2' => 6)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => '<=', 'check2' => 6)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => 'equal to', 'check2' => 6)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => '==','check2' =>  6)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => 'not equal', 'check2' => 7)));
		$this->assertFalse(Validation::comparison(array('check1' => 7, 'operator' => '!=', 'check2' => 7)));
	}
/**
 * testCustom method
 *
 * @access public
 * @return void
 */
	function testCustom() {
		$this->assertTrue(Validation::custom('12345', '/(?<!\\S)\\d++(?!\\S)/'));
		$this->assertFalse(Validation::custom('Text', '/(?<!\\S)\\d++(?!\\S)/'));
		$this->assertFalse(Validation::custom('123.45', '/(?<!\\S)\\d++(?!\\S)/'));
		$this->assertFalse(Validation::custom('missing regex'));
	}
/**
 * testCustomAsArray method
 *
 * @access public
 * @return void
 */
	function testCustomAsArray() {
		$this->assertTrue(Validation::custom(array('check' => '12345', 'regex' => '/(?<!\\S)\\d++(?!\\S)/')));
		$this->assertFalse(Validation::custom(array('check' => 'Text', 'regex' => '/(?<!\\S)\\d++(?!\\S)/')));
		$this->assertFalse(Validation::custom(array('check' => '123.45', 'regex' => '/(?<!\\S)\\d++(?!\\S)/')));
	}
/**
 * testDateDdmmyyyy method
 *
 * @access public
 * @return void
 */
	function testDateDdmmyyyy() {
		$this->assertTrue(Validation::date('27-12-2006', array('dmy')));
		$this->assertTrue(Validation::date('27.12.2006', array('dmy')));
		$this->assertTrue(Validation::date('27/12/2006', array('dmy')));
		$this->assertTrue(Validation::date('27 12 2006', array('dmy')));
		$this->assertFalse(Validation::date('00-00-0000', array('dmy')));
		$this->assertFalse(Validation::date('00.00.0000', array('dmy')));
		$this->assertFalse(Validation::date('00/00/0000', array('dmy')));
		$this->assertFalse(Validation::date('00 00 0000', array('dmy')));
		$this->assertFalse(Validation::date('31-11-2006', array('dmy')));
		$this->assertFalse(Validation::date('31.11.2006', array('dmy')));
		$this->assertFalse(Validation::date('31/11/2006', array('dmy')));
		$this->assertFalse(Validation::date('31 11 2006', array('dmy')));
	}
/**
 * testDateDdmmyyyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateDdmmyyyyLeapYear() {
		$this->assertTrue(Validation::date('29-02-2004', array('dmy')));
		$this->assertTrue(Validation::date('29.02.2004', array('dmy')));
		$this->assertTrue(Validation::date('29/02/2004', array('dmy')));
		$this->assertTrue(Validation::date('29 02 2004', array('dmy')));
		$this->assertFalse(Validation::date('29-02-2006', array('dmy')));
		$this->assertFalse(Validation::date('29.02.2006', array('dmy')));
		$this->assertFalse(Validation::date('29/02/2006', array('dmy')));
		$this->assertFalse(Validation::date('29 02 2006', array('dmy')));
	}
/**
 * testDateDdmmyy method
 *
 * @access public
 * @return void
 */
	function testDateDdmmyy() {
		$this->assertTrue(Validation::date('27-12-06', array('dmy')));
		$this->assertTrue(Validation::date('27.12.06', array('dmy')));
		$this->assertTrue(Validation::date('27/12/06', array('dmy')));
		$this->assertTrue(Validation::date('27 12 06', array('dmy')));
		$this->assertFalse(Validation::date('00-00-00', array('dmy')));
		$this->assertFalse(Validation::date('00.00.00', array('dmy')));
		$this->assertFalse(Validation::date('00/00/00', array('dmy')));
		$this->assertFalse(Validation::date('00 00 00', array('dmy')));
		$this->assertFalse(Validation::date('31-11-06', array('dmy')));
		$this->assertFalse(Validation::date('31.11.06', array('dmy')));
		$this->assertFalse(Validation::date('31/11/06', array('dmy')));
		$this->assertFalse(Validation::date('31 11 06', array('dmy')));
	}
/**
 * testDateDdmmyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateDdmmyyLeapYear() {
		$this->assertTrue(Validation::date('29-02-04', array('dmy')));
		$this->assertTrue(Validation::date('29.02.04', array('dmy')));
		$this->assertTrue(Validation::date('29/02/04', array('dmy')));
		$this->assertTrue(Validation::date('29 02 04', array('dmy')));
		$this->assertFalse(Validation::date('29-02-06', array('dmy')));
		$this->assertFalse(Validation::date('29.02.06', array('dmy')));
		$this->assertFalse(Validation::date('29/02/06', array('dmy')));
		$this->assertFalse(Validation::date('29 02 06', array('dmy')));
	}
/**
 * testDateDmyy method
 *
 * @access public
 * @return void
 */
	function testDateDmyy() {
		$this->assertTrue(Validation::date('7-2-06', array('dmy')));
		$this->assertTrue(Validation::date('7.2.06', array('dmy')));
		$this->assertTrue(Validation::date('7/2/06', array('dmy')));
		$this->assertTrue(Validation::date('7 2 06', array('dmy')));
		$this->assertFalse(Validation::date('0-0-00', array('dmy')));
		$this->assertFalse(Validation::date('0.0.00', array('dmy')));
		$this->assertFalse(Validation::date('0/0/00', array('dmy')));
		$this->assertFalse(Validation::date('0 0 00', array('dmy')));
		$this->assertFalse(Validation::date('32-2-06', array('dmy')));
		$this->assertFalse(Validation::date('32.2.06', array('dmy')));
		$this->assertFalse(Validation::date('32/2/06', array('dmy')));
		$this->assertFalse(Validation::date('32 2 06', array('dmy')));
	}
/**
 * testDateDmyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateDmyyLeapYear() {
		$this->assertTrue(Validation::date('29-2-04', array('dmy')));
		$this->assertTrue(Validation::date('29.2.04', array('dmy')));
		$this->assertTrue(Validation::date('29/2/04', array('dmy')));
		$this->assertTrue(Validation::date('29 2 04', array('dmy')));
		$this->assertFalse(Validation::date('29-2-06', array('dmy')));
		$this->assertFalse(Validation::date('29.2.06', array('dmy')));
		$this->assertFalse(Validation::date('29/2/06', array('dmy')));
		$this->assertFalse(Validation::date('29 2 06', array('dmy')));
	}
/**
 * testDateDmyyyy method
 *
 * @access public
 * @return void
 */
	function testDateDmyyyy() {
		$this->assertTrue(Validation::date('7-2-2006', array('dmy')));
		$this->assertTrue(Validation::date('7.2.2006', array('dmy')));
		$this->assertTrue(Validation::date('7/2/2006', array('dmy')));
		$this->assertTrue(Validation::date('7 2 2006', array('dmy')));
		$this->assertFalse(Validation::date('0-0-0000', array('dmy')));
		$this->assertFalse(Validation::date('0.0.0000', array('dmy')));
		$this->assertFalse(Validation::date('0/0/0000', array('dmy')));
		$this->assertFalse(Validation::date('0 0 0000', array('dmy')));
		$this->assertFalse(Validation::date('32-2-2006', array('dmy')));
		$this->assertFalse(Validation::date('32.2.2006', array('dmy')));
		$this->assertFalse(Validation::date('32/2/2006', array('dmy')));
		$this->assertFalse(Validation::date('32 2 2006', array('dmy')));
	}
/**
 * testDateDmyyyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateDmyyyyLeapYear() {
		$this->assertTrue(Validation::date('29-2-2004', array('dmy')));
		$this->assertTrue(Validation::date('29.2.2004', array('dmy')));
		$this->assertTrue(Validation::date('29/2/2004', array('dmy')));
		$this->assertTrue(Validation::date('29 2 2004', array('dmy')));
		$this->assertFalse(Validation::date('29-2-2006', array('dmy')));
		$this->assertFalse(Validation::date('29.2.2006', array('dmy')));
		$this->assertFalse(Validation::date('29/2/2006', array('dmy')));
		$this->assertFalse(Validation::date('29 2 2006', array('dmy')));
	}
/**
 * testDateMmddyyyy method
 *
 * @access public
 * @return void
 */
	function testDateMmddyyyy() {
		$this->assertTrue(Validation::date('12-27-2006', array('mdy')));
		$this->assertTrue(Validation::date('12.27.2006', array('mdy')));
		$this->assertTrue(Validation::date('12/27/2006', array('mdy')));
		$this->assertTrue(Validation::date('12 27 2006', array('mdy')));
		$this->assertFalse(Validation::date('00-00-0000', array('mdy')));
		$this->assertFalse(Validation::date('00.00.0000', array('mdy')));
		$this->assertFalse(Validation::date('00/00/0000', array('mdy')));
		$this->assertFalse(Validation::date('00 00 0000', array('mdy')));
		$this->assertFalse(Validation::date('11-31-2006', array('mdy')));
		$this->assertFalse(Validation::date('11.31.2006', array('mdy')));
		$this->assertFalse(Validation::date('11/31/2006', array('mdy')));
		$this->assertFalse(Validation::date('11 31 2006', array('mdy')));
	}
/**
 * testDateMmddyyyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateMmddyyyyLeapYear() {
		$this->assertTrue(Validation::date('02-29-2004', array('mdy')));
		$this->assertTrue(Validation::date('02.29.2004', array('mdy')));
		$this->assertTrue(Validation::date('02/29/2004', array('mdy')));
		$this->assertTrue(Validation::date('02 29 2004', array('mdy')));
		$this->assertFalse(Validation::date('02-29-2006', array('mdy')));
		$this->assertFalse(Validation::date('02.29.2006', array('mdy')));
		$this->assertFalse(Validation::date('02/29/2006', array('mdy')));
		$this->assertFalse(Validation::date('02 29 2006', array('mdy')));
	}
/**
 * testDateMmddyy method
 *
 * @access public
 * @return void
 */
	function testDateMmddyy() {
		$this->assertTrue(Validation::date('12-27-06', array('mdy')));
		$this->assertTrue(Validation::date('12.27.06', array('mdy')));
		$this->assertTrue(Validation::date('12/27/06', array('mdy')));
		$this->assertTrue(Validation::date('12 27 06', array('mdy')));
		$this->assertFalse(Validation::date('00-00-00', array('mdy')));
		$this->assertFalse(Validation::date('00.00.00', array('mdy')));
		$this->assertFalse(Validation::date('00/00/00', array('mdy')));
		$this->assertFalse(Validation::date('00 00 00', array('mdy')));
		$this->assertFalse(Validation::date('11-31-06', array('mdy')));
		$this->assertFalse(Validation::date('11.31.06', array('mdy')));
		$this->assertFalse(Validation::date('11/31/06', array('mdy')));
		$this->assertFalse(Validation::date('11 31 06', array('mdy')));
	}
/**
 * testDateMmddyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateMmddyyLeapYear() {
		$this->assertTrue(Validation::date('02-29-04', array('mdy')));
		$this->assertTrue(Validation::date('02.29.04', array('mdy')));
		$this->assertTrue(Validation::date('02/29/04', array('mdy')));
		$this->assertTrue(Validation::date('02 29 04', array('mdy')));
		$this->assertFalse(Validation::date('02-29-06', array('mdy')));
		$this->assertFalse(Validation::date('02.29.06', array('mdy')));
		$this->assertFalse(Validation::date('02/29/06', array('mdy')));
		$this->assertFalse(Validation::date('02 29 06', array('mdy')));
	}
/**
 * testDateMdyy method
 *
 * @access public
 * @return void
 */
	function testDateMdyy() {
		$this->assertTrue(Validation::date('2-7-06', array('mdy')));
		$this->assertTrue(Validation::date('2.7.06', array('mdy')));
		$this->assertTrue(Validation::date('2/7/06', array('mdy')));
		$this->assertTrue(Validation::date('2 7 06', array('mdy')));
		$this->assertFalse(Validation::date('0-0-00', array('mdy')));
		$this->assertFalse(Validation::date('0.0.00', array('mdy')));
		$this->assertFalse(Validation::date('0/0/00', array('mdy')));
		$this->assertFalse(Validation::date('0 0 00', array('mdy')));
		$this->assertFalse(Validation::date('2-32-06', array('mdy')));
		$this->assertFalse(Validation::date('2.32.06', array('mdy')));
		$this->assertFalse(Validation::date('2/32/06', array('mdy')));
		$this->assertFalse(Validation::date('2 32 06', array('mdy')));
	}
/**
 * testDateMdyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateMdyyLeapYear() {
		$this->assertTrue(Validation::date('2-29-04', array('mdy')));
		$this->assertTrue(Validation::date('2.29.04', array('mdy')));
		$this->assertTrue(Validation::date('2/29/04', array('mdy')));
		$this->assertTrue(Validation::date('2 29 04', array('mdy')));
		$this->assertFalse(Validation::date('2-29-06', array('mdy')));
		$this->assertFalse(Validation::date('2.29.06', array('mdy')));
		$this->assertFalse(Validation::date('2/29/06', array('mdy')));
		$this->assertFalse(Validation::date('2 29 06', array('mdy')));
	}
/**
 * testDateMdyyyy method
 *
 * @access public
 * @return void
 */
	function testDateMdyyyy() {
		$this->assertTrue(Validation::date('2-7-2006', array('mdy')));
		$this->assertTrue(Validation::date('2.7.2006', array('mdy')));
		$this->assertTrue(Validation::date('2/7/2006', array('mdy')));
		$this->assertTrue(Validation::date('2 7 2006', array('mdy')));
		$this->assertFalse(Validation::date('0-0-0000', array('mdy')));
		$this->assertFalse(Validation::date('0.0.0000', array('mdy')));
		$this->assertFalse(Validation::date('0/0/0000', array('mdy')));
		$this->assertFalse(Validation::date('0 0 0000', array('mdy')));
		$this->assertFalse(Validation::date('2-32-2006', array('mdy')));
		$this->assertFalse(Validation::date('2.32.2006', array('mdy')));
		$this->assertFalse(Validation::date('2/32/2006', array('mdy')));
		$this->assertFalse(Validation::date('2 32 2006', array('mdy')));
	}
/**
 * testDateMdyyyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateMdyyyyLeapYear() {
		$this->assertTrue(Validation::date('2-29-2004', array('mdy')));
		$this->assertTrue(Validation::date('2.29.2004', array('mdy')));
		$this->assertTrue(Validation::date('2/29/2004', array('mdy')));
		$this->assertTrue(Validation::date('2 29 2004', array('mdy')));
		$this->assertFalse(Validation::date('2-29-2006', array('mdy')));
		$this->assertFalse(Validation::date('2.29.2006', array('mdy')));
		$this->assertFalse(Validation::date('2/29/2006', array('mdy')));
		$this->assertFalse(Validation::date('2 29 2006', array('mdy')));
	}
/**
 * testDateYyyymmdd method
 *
 * @access public
 * @return void
 */
	function testDateYyyymmdd() {
		$this->assertTrue(Validation::date('2006-12-27', array('ymd')));
		$this->assertTrue(Validation::date('2006.12.27', array('ymd')));
		$this->assertTrue(Validation::date('2006/12/27', array('ymd')));
		$this->assertTrue(Validation::date('2006 12 27', array('ymd')));
		$this->assertFalse(Validation::date('2006-11-31', array('ymd')));
		$this->assertFalse(Validation::date('2006.11.31', array('ymd')));
		$this->assertFalse(Validation::date('2006/11/31', array('ymd')));
		$this->assertFalse(Validation::date('2006 11 31', array('ymd')));
	}
/**
 * testDateYyyymmddLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateYyyymmddLeapYear() {
		$this->assertTrue(Validation::date('2004-02-29', array('ymd')));
		$this->assertTrue(Validation::date('2004.02.29', array('ymd')));
		$this->assertTrue(Validation::date('2004/02/29', array('ymd')));
		$this->assertTrue(Validation::date('2004 02 29', array('ymd')));
		$this->assertFalse(Validation::date('2006-02-29', array('ymd')));
		$this->assertFalse(Validation::date('2006.02.29', array('ymd')));
		$this->assertFalse(Validation::date('2006/02/29', array('ymd')));
		$this->assertFalse(Validation::date('2006 02 29', array('ymd')));
	}
/**
 * testDateYymmdd method
 *
 * @access public
 * @return void
 */
	function testDateYymmdd() {
		$this->assertTrue(Validation::date('06-12-27', array('ymd')));
		$this->assertTrue(Validation::date('06.12.27', array('ymd')));
		$this->assertTrue(Validation::date('06/12/27', array('ymd')));
		$this->assertTrue(Validation::date('06 12 27', array('ymd')));
		$this->assertFalse(Validation::date('12/27/2600', array('ymd')));
		$this->assertFalse(Validation::date('12.27.2600', array('ymd')));
		$this->assertFalse(Validation::date('12/27/2600', array('ymd')));
		$this->assertFalse(Validation::date('12 27 2600', array('ymd')));
		$this->assertFalse(Validation::date('06-11-31', array('ymd')));
		$this->assertFalse(Validation::date('06.11.31', array('ymd')));
		$this->assertFalse(Validation::date('06/11/31', array('ymd')));
		$this->assertFalse(Validation::date('06 11 31', array('ymd')));
	}
/**
 * testDateYymmddLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateYymmddLeapYear() {
		$this->assertTrue(Validation::date('2004-02-29', array('ymd')));
		$this->assertTrue(Validation::date('2004.02.29', array('ymd')));
		$this->assertTrue(Validation::date('2004/02/29', array('ymd')));
		$this->assertTrue(Validation::date('2004 02 29', array('ymd')));
		$this->assertFalse(Validation::date('2006-02-29', array('ymd')));
		$this->assertFalse(Validation::date('2006.02.29', array('ymd')));
		$this->assertFalse(Validation::date('2006/02/29', array('ymd')));
		$this->assertFalse(Validation::date('2006 02 29', array('ymd')));
	}
/**
 * testDateDdMMMMyyyy method
 *
 * @access public
 * @return void
 */
	function testDateDdMMMMyyyy() {
		$this->assertTrue(Validation::date('27 December 2006', array('dMy')));
		$this->assertTrue(Validation::date('27 Dec 2006', array('dMy')));
		$this->assertFalse(Validation::date('2006 Dec 27', array('dMy')));
		$this->assertFalse(Validation::date('2006 December 27', array('dMy')));
	}
/**
 * testDateDdMMMMyyyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateDdMMMMyyyyLeapYear() {
		$this->assertTrue(Validation::date('29 February 2004', array('dMy')));
		$this->assertFalse(Validation::date('29 February 2006', array('dMy')));
	}
/**
 * testDateMmmmDdyyyy method
 *
 * @access public
 * @return void
 */
	function testDateMmmmDdyyyy() {
		$this->assertTrue(Validation::date('December 27, 2006', array('Mdy')));
		$this->assertTrue(Validation::date('Dec 27, 2006', array('Mdy')));
		$this->assertTrue(Validation::date('December 27 2006', array('Mdy')));
		$this->assertTrue(Validation::date('Dec 27 2006', array('Mdy')));
		$this->assertFalse(Validation::date('27 Dec 2006', array('Mdy')));
		$this->assertFalse(Validation::date('2006 December 27', array('Mdy')));
	}
/**
 * testDateMmmmDdyyyyLeapYear method
 *
 * @access public
 * @return void
 */
	function testDateMmmmDdyyyyLeapYear() {
		$this->assertTrue(Validation::date('February 29, 2004', array('Mdy')));
		$this->assertTrue(Validation::date('Feb 29, 2004', array('Mdy')));
		$this->assertTrue(Validation::date('February 29 2004', array('Mdy')));
		$this->assertTrue(Validation::date('Feb 29 2004', array('Mdy')));
		$this->assertFalse(Validation::date('February 29, 2006', array('Mdy')));
	}
/**
 * testDateMy method
 *
 * @access public
 * @return void
 */
	function testDateMy() {
		$this->assertTrue(Validation::date('December 2006', array('My')));
		$this->assertTrue(Validation::date('Dec 2006', array('My')));
		$this->assertTrue(Validation::date('December/2006', array('My')));
		$this->assertTrue(Validation::date('Dec/2006', array('My')));
	}
/**
 * testDateMyNumeric method
 *
 * @access public
 * @return void
 */
	function testDateMyNumeric() {
		$this->assertTrue(Validation::date('12/2006', array('my')));
		$this->assertTrue(Validation::date('12-2006', array('my')));
		$this->assertTrue(Validation::date('12.2006', array('my')));
		$this->assertTrue(Validation::date('12 2006', array('my')));
		$this->assertFalse(Validation::date('12/06', array('my')));
		$this->assertFalse(Validation::date('12-06', array('my')));
		$this->assertFalse(Validation::date('12.06', array('my')));
		$this->assertFalse(Validation::date('12 06', array('my')));
	}
/**
 * testTime method
 *
 * @access public
 * @return void
 */
	function testTime() {
		$this->assertTrue(Validation::time('00:00'));
		$this->assertTrue(Validation::time('23:59'));
		$this->assertFalse(Validation::time('24:00'));
		$this->assertTrue(Validation::time('12:00'));
		$this->assertTrue(Validation::time('12:01'));
		$this->assertTrue(Validation::time('12:01am'));
		$this->assertTrue(Validation::time('12:01pm'));
		$this->assertTrue(Validation::time('1pm'));
		$this->assertTrue(Validation::time('01:00'));
		$this->assertFalse(Validation::time('1:00'));
		$this->assertTrue(Validation::time('1:00pm'));
		$this->assertFalse(Validation::time('13:00pm'));
		$this->assertFalse(Validation::time('9:00'));
	}
/**
 * testBoolean method
 *
 * @access public
 * @return void
 */
	function testBoolean() {
		$this->assertTrue(Validation::boolean('0'));
		$this->assertTrue(Validation::boolean('1'));
		$this->assertTrue(Validation::boolean(0));
		$this->assertTrue(Validation::boolean(1));
		$this->assertTrue(Validation::boolean(true));
		$this->assertTrue(Validation::boolean(false));
		$this->assertFalse(Validation::boolean('true'));
		$this->assertFalse(Validation::boolean('false'));
		$this->assertFalse(Validation::boolean('-1'));
		$this->assertFalse(Validation::boolean('2'));
		$this->assertFalse(Validation::boolean('Boo!'));
	}
/**
 * testDateCustomRegx method
 *
 * @access public
 * @return void
 */
	function testDateCustomRegx() {
		$this->assertTrue(Validation::date('2006-12-27', null, '%^(19|20)[0-9]{2}[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$%'));
		$this->assertFalse(Validation::date('12-27-2006', null, '%^(19|20)[0-9]{2}[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$%'));
	}
/**
 * testDecimal method
 *
 * @access public
 * @return void
 */
	function testDecimal() {
		$this->assertTrue(Validation::decimal('+1234.54321'));
		$this->assertTrue(Validation::decimal('-1234.54321'));
		$this->assertTrue(Validation::decimal('1234.54321'));
		$this->assertTrue(Validation::decimal('+0123.45e6'));
		$this->assertTrue(Validation::decimal('-0123.45e6'));
		$this->assertTrue(Validation::decimal('0123.45e6'));
		$this->assertFalse(Validation::decimal('string'));
		$this->assertFalse(Validation::decimal('1234'));
		$this->assertFalse(Validation::decimal('-1234'));
		$this->assertFalse(Validation::decimal('+1234'));
	}
/**
 * testDecimalWithPlaces method
 *
 * @access public
 * @return void
 */
	function testDecimalWithPlaces() {
		$this->assertTrue(Validation::decimal('.27', '2'));
		$this->assertTrue(Validation::decimal(.27, 2));
		$this->assertTrue(Validation::decimal(-.27, 2));
		$this->assertTrue(Validation::decimal(+.27, 2));
		$this->assertTrue(Validation::decimal('.277', '3'));
		$this->assertTrue(Validation::decimal(.277, 3));
		$this->assertTrue(Validation::decimal(-.277, 3));
		$this->assertTrue(Validation::decimal(+.277, 3));
		$this->assertTrue(Validation::decimal('1234.5678', '4'));
		$this->assertTrue(Validation::decimal(1234.5678, 4));
		$this->assertTrue(Validation::decimal(-1234.5678, 4));
		$this->assertTrue(Validation::decimal(+1234.5678, 4));
		$this->assertFalse(Validation::decimal('1234.5678', '3'));
		$this->assertFalse(Validation::decimal(1234.5678, 3));
		$this->assertFalse(Validation::decimal(-1234.5678, 3));
		$this->assertFalse(Validation::decimal(+1234.5678, 3));
	}
/**
 * testDecimalCustomRegex method
 *
 * @access public
 * @return void
 */
	function testDecimalCustomRegex() {
		$this->assertTrue(Validation::decimal('1.54321', null, '/^[-+]?[0-9]+(\\.[0-9]+)?$/s'));
		$this->assertFalse(Validation::decimal('.54321', null, '/^[-+]?[0-9]+(\\.[0-9]+)?$/s'));
	}
/**
 * testEmail method
 *
 * @access public
 * @return void
 */
	function testEmail() {
		$this->assertTrue(Validation::email('abc.efg@domain.com'));
		$this->assertTrue(Validation::email('efg@domain.com'));
		$this->assertTrue(Validation::email('abc-efg@domain.com'));
		$this->assertTrue(Validation::email('abc_efg@domain.com'));
		$this->assertTrue(Validation::email('raw@test.ra.ru'));
		$this->assertTrue(Validation::email('abc-efg@domain-hyphened.com'));
		$this->assertTrue(Validation::email("p.o'malley@domain.com"));
		$this->assertTrue(Validation::email('abc+efg@domain.com'));
		$this->assertTrue(Validation::email('abc&efg@domain.com'));
		$this->assertTrue(Validation::email('abc.efg@12345.com'));
		$this->assertTrue(Validation::email('abc.efg@12345.co.jp'));
		$this->assertTrue(Validation::email('abc@g.cn'));
		$this->assertTrue(Validation::email('abc@x.com'));

		// all ICANN TLDs
		$this->assertTrue(Validation::email('abc@example.aero'));
		$this->assertTrue(Validation::email('abc@example.asia'));
		$this->assertTrue(Validation::email('abc@example.biz'));
		$this->assertTrue(Validation::email('abc@example.cat'));
		$this->assertTrue(Validation::email('abc@example.com'));
		$this->assertTrue(Validation::email('abc@example.coop'));
		$this->assertTrue(Validation::email('abc@example.edu'));
		$this->assertTrue(Validation::email('abc@example.gov'));
		$this->assertTrue(Validation::email('abc@example.info'));
		$this->assertTrue(Validation::email('abc@example.int'));
		$this->assertTrue(Validation::email('abc@example.jobs'));
		$this->assertTrue(Validation::email('abc@example.mil'));
		$this->assertTrue(Validation::email('abc@example.mobi'));
		$this->assertTrue(Validation::email('abc@example.museum'));
		$this->assertTrue(Validation::email('abc@example.name'));
		$this->assertTrue(Validation::email('abc@example.net'));
		$this->assertTrue(Validation::email('abc@example.org'));
		$this->assertTrue(Validation::email('abc@example.pro'));
		$this->assertTrue(Validation::email('abc@example.tel'));
		$this->assertTrue(Validation::email('abc@example.travel'));
		$this->assertTrue(Validation::email('someone@st.t-com.hr'));

		// strange, but technically valid email addresses
		$this->assertTrue(Validation::email('S=postmaster/OU=rz/P=uni-frankfurt/A=d400/C=de@gateway.d400.de'));
		$this->assertTrue(Validation::email('customer/department=shipping@example.com'));
		$this->assertTrue(Validation::email('$A12345@example.com'));
		$this->assertTrue(Validation::email('!def!xyz%abc@example.com'));
		$this->assertTrue(Validation::email('_somename@example.com'));

		// invalid addresses
		$this->assertFalse(Validation::email('abc@example'));
		$this->assertFalse(Validation::email('abc@example.c'));
		$this->assertFalse(Validation::email('abc@example.com.'));
		$this->assertFalse(Validation::email('abc.@example.com'));
		$this->assertFalse(Validation::email('abc@example..com'));
		$this->assertFalse(Validation::email('abc@example.com.a'));
		$this->assertFalse(Validation::email('abc@example.toolong'));
		$this->assertFalse(Validation::email('abc;@example.com'));
		$this->assertFalse(Validation::email('abc@example.com;'));
		$this->assertFalse(Validation::email('abc@efg@example.com'));
		$this->assertFalse(Validation::email('abc@@example.com'));
		$this->assertFalse(Validation::email('abc efg@example.com'));
		$this->assertFalse(Validation::email('abc,efg@example.com'));
		$this->assertFalse(Validation::email('abc@sub,example.com'));
		$this->assertFalse(Validation::email("abc@sub'example.com"));
		$this->assertFalse(Validation::email('abc@sub/example.com'));
		$this->assertFalse(Validation::email('abc@yahoo!.com'));
		$this->assertFalse(Validation::email("Nyrée.surname@example.com"));
		$this->assertFalse(Validation::email('abc@example_underscored.com'));
		$this->assertFalse(Validation::email('raw@test.ra.ru....com'));
	}
/**
 * testEmailDeep method
 *
 * @access public
 * @return void
 */
	function testEmailDeep() {
		$this->assertTrue(Validation::email('abc.efg@cakephp.org', true));
		$this->assertFalse(Validation::email('abc.efg@caphpkeinvalid.com', true));
		$this->assertFalse(Validation::email('abc@example.abcd', true));
	}
/**
 * testEmailCustomRegex method
 *
 * @access public
 * @return void
 */
	function testEmailCustomRegex() {
		$this->assertTrue(Validation::email('abc.efg@cakephp.org', null, '/^[A-Z0-9._%-]+@[A-Z0-9.-]+\\.[A-Z]{2,4}$/i'));
		$this->assertFalse(Validation::email('abc.efg@com.caphpkeinvalid', null, '/^[A-Z0-9._%-]+@[A-Z0-9.-]+\\.[A-Z]{2,4}$/i'));
	}
/**
 * testEqualTo method
 *
 * @access public
 * @return void
 */
	function testEqualTo() {
		$this->assertTrue(Validation::equalTo("1", "1"));
		$this->assertFalse(Validation::equalTo(1, "1"));
		$this->assertFalse(Validation::equalTo("", null));
		$this->assertFalse(Validation::equalTo("", false));
		$this->assertFalse(Validation::equalTo(0, false));
		$this->assertFalse(Validation::equalTo(null, false));
	}
/**
 * testIp method
 *
 * @access public
 * @return void
 */
	function testIp() {
		$this->assertTrue(Validation::ip('0.0.0.0'));
		$this->assertTrue(Validation::ip('192.168.1.156'));
		$this->assertTrue(Validation::ip('255.255.255.255'));
		$this->assertFalse(Validation::ip('127.0.0'));
		$this->assertFalse(Validation::ip('127.0.0.a'));
		$this->assertFalse(Validation::ip('127.0.0.256'));
	}
/**
 * testMaxLength method
 *
 * @access public
 * @return void
 */
	function testMaxLength() {
		$this->assertTrue(Validation::maxLength('ab', 3));
		$this->assertTrue(Validation::maxLength('abc', 3));
		$this->assertFalse(Validation::maxLength('abcd', 3));
	}
/**
 * testMinLength method
 *
 * @access public
 * @return void
 */
	function testMinLength() {
		$this->assertFalse(Validation::minLength('ab', 3));
		$this->assertTrue(Validation::minLength('abc', 3));
		$this->assertTrue(Validation::minLength('abcd', 3));
	}
/**
 * testUrl method
 *
 * @access public
 * @return void
 */
	function testUrl() {
		$this->assertTrue(Validation::url('http://www.cakephp.org'));
		$this->assertTrue(Validation::url('http://cakephp.org'));
		$this->assertTrue(Validation::url('http://www.cakephp.org/somewhere#anchor'));
		$this->assertTrue(Validation::url('http://192.168.0.1'));
		$this->assertTrue(Validation::url('https://www.cakephp.org'));
		$this->assertTrue(Validation::url('https://cakephp.org'));
		$this->assertTrue(Validation::url('https://www.cakephp.org/somewhere#anchor'));
		$this->assertTrue(Validation::url('https://192.168.0.1'));
		$this->assertTrue(Validation::url('ftps://www.cakephp.org/pub/cake'));
		$this->assertTrue(Validation::url('ftps://cakephp.org/pub/cake'));
		$this->assertTrue(Validation::url('ftps://192.168.0.1/pub/cake'));
		$this->assertTrue(Validation::url('ftp://www.cakephp.org/pub/cake'));
		$this->assertTrue(Validation::url('ftp://cakephp.org/pub/cake'));
		$this->assertTrue(Validation::url('ftp://192.168.0.1/pub/cake'));
		$this->assertFalse(Validation::url('ftps://256.168.0.1/pub/cake'));
		$this->assertFalse(Validation::url('ftp://256.168.0.1/pub/cake'));
		$this->assertTrue(Validation::url('https://my.domain.com/gizmo/app?class=MySip;proc=start'));
		$this->assertTrue(Validation::url('www.domain.tld'));
		$this->assertFalse(Validation::url('http://w_w.domain.co_m'));
		$this->assertFalse(Validation::url('http://www.domain.12com'));
		$this->assertFalse(Validation::url('http://www.domain.longttldnotallowed'));
		$this->assertFalse(Validation::url('http://www.-invaliddomain.tld'));
		$this->assertFalse(Validation::url('http://www.domain.-invalidtld'));
		$this->assertTrue(Validation::url('http://123456789112345678921234567893123456789412345678951234567896123.com'));
		$this->assertFalse(Validation::url('http://this-domain-is-too-loooooong-by-icann-rules-maximum-length-is-63.com'));
		$this->assertTrue(Validation::url('http://www.domain.com/blogs/index.php?blog=6&tempskin=_rss2'));
		$this->assertTrue(Validation::url('http://www.domain.com/blogs/parenth()eses.php'));
		$this->assertTrue(Validation::url('http://www.domain.com/index.php?get=params&amp;get2=params'));
		$this->assertTrue(Validation::url('http://www.domain.com/ndex.php?get=params&amp;get2=params#anchor'));
		$this->assertFalse(Validation::url('http://www.domain.com/fakeenco%ode'));
		$this->assertTrue(Validation::url('http://www.domain.com/real%20url%20encodeing'));
		$this->assertTrue(Validation::url('http://en.wikipedia.org/wiki/Architectural_pattern_(computer_science)'));
		$this->assertFalse(Validation::url('http://en.(wikipedia).org/'));
		$this->assertFalse(Validation::url('www.cakephp.org', true));
		$this->assertTrue(Validation::url('http://www.cakephp.org', true));
	}
/**
 * testInList method
 *
 * @access public
 * @return void
 */
	function testInList() {
		$this->assertTrue(Validation::inList('one', array('one', 'two')));
		$this->assertTrue(Validation::inList('two', array('one', 'two')));
		$this->assertFalse(Validation::inList('three', array('one', 'two')));
	}
/**
 * testValidNumber method
 *
 * @access public
 * @return void
 */
	function testValidNumber() {
		$this->assertTrue(Validation::custom('12345', VALID_NUMBER));
		$this->assertTrue(Validation::custom('-12345', VALID_NUMBER));
		$this->assertTrue(Validation::custom('+12345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('--12345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('++12345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('a12345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('12345z', VALID_NUMBER));
		$this->assertFalse(Validation::custom('-a12345z', VALID_NUMBER));
		$this->assertFalse(Validation::custom('-', VALID_NUMBER));
		$this->assertFalse(Validation::custom('123-12345', VALID_NUMBER));
		$this->assertTrue(Validation::custom('1.2345', VALID_NUMBER));
		$this->assertTrue(Validation::custom('-1.2345', VALID_NUMBER));
		$this->assertTrue(Validation::custom('+1.2345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('1..2345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('-1..2345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('+1..2345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('.2345', VALID_NUMBER));
		$this->assertFalse(Validation::custom('12345.', VALID_NUMBER));
	}
/**
 * testRange method
 *
 * @access public
 * @return void
 */
	function testRange() {
		$this->assertFalse(Validation::range(20, 100, 1));
		$this->assertTrue(Validation::range(20, 1, 100));
		$this->assertFalse(Validation::range(.5, 1, 100));
		$this->assertTrue(Validation::range(.5, 0, 100));
		$this->assertTrue(Validation::range(5));
		$this->assertTrue(Validation::range(-5, -10, 1));
		$this->assertFalse(Validation::range('word'));
	}
/**
 * testExtension method
 *
 * @access public
 * @return void
 */
	function testExtension() {
		$this->assertTrue(Validation::extension('extension.jpeg'));
		$this->assertTrue(Validation::extension('extension.JPEG'));
		$this->assertTrue(Validation::extension('extension.gif'));
		$this->assertTrue(Validation::extension('extension.GIF'));
		$this->assertTrue(Validation::extension('extension.png'));
		$this->assertTrue(Validation::extension('extension.jpg'));
		$this->assertTrue(Validation::extension('extension.JPG'));
		$this->assertFalse(Validation::extension('noextension'));
		$this->assertTrue(Validation::extension('extension.pdf', array('PDF')));
		$this->assertFalse(Validation::extension('extension.jpg', array('GIF')));
		$this->assertTrue(Validation::extension(array('extension.JPG', 'extension.gif', 'extension.png')));
		$this->assertTrue(Validation::extension(array('file' => array('name' => 'file.jpg'))));
		$this->assertTrue(Validation::extension(array('file1' => array('name' => 'file.jpg'),
												'file2' => array('name' => 'file.jpg'),
												'file3' => array('name' => 'file.jpg'))));
		$this->assertFalse(Validation::extension(array('file1' => array('name' => 'file.jpg'),
												'file2' => array('name' => 'file.jpg'),
												'file3' => array('name' => 'file.jpg')), array('gif')));

		$this->assertFalse(Validation::extension(array('noextension', 'extension.JPG', 'extension.gif', 'extension.png')));
		$this->assertFalse(Validation::extension(array('extension.pdf', 'extension.JPG', 'extension.gif', 'extension.png')));
	}
/**
 * testMoney method
 *
 * @access public
 * @return void
 */
	function testMoney() {
		$this->assertTrue(Validation::money('$100'));
		$this->assertTrue(Validation::money('$100.11'));
		$this->assertTrue(Validation::money('$100.112'));
		$this->assertFalse(Validation::money('$100.1'));
		$this->assertFalse(Validation::money('$100.1111'));
		$this->assertFalse(Validation::money('text'));

		$this->assertTrue(Validation::money('100', 'right'));
		$this->assertTrue(Validation::money('100.11$', 'right'));
		$this->assertTrue(Validation::money('100.112$', 'right'));
		$this->assertFalse(Validation::money('100.1$', 'right'));
		$this->assertFalse(Validation::money('100.1111$', 'right'));

		$this->assertTrue(Validation::money('€100'));
		$this->assertTrue(Validation::money('€100.11'));
		$this->assertTrue(Validation::money('€100.112'));
		$this->assertFalse(Validation::money('€100.1'));
		$this->assertFalse(Validation::money('€100.1111'));

		$this->assertTrue(Validation::money('100', 'right'));
		$this->assertTrue(Validation::money('100.11€', 'right'));
		$this->assertTrue(Validation::money('100.112€', 'right'));
		$this->assertFalse(Validation::money('100.1€', 'right'));
		$this->assertFalse(Validation::money('100.1111€', 'right'));
	}
/**
 * Test Multiple Select Validation
 *
 * @access public
 * @return void
 **/
	function testMultiple() {
		$this->assertTrue(Validation::multiple(array(0, 1, 2, 3)));
		$this->assertTrue(Validation::multiple(array(50, 32, 22, 0)));
		$this->assertTrue(Validation::multiple(array('str', 'var', 'enum', 0)));
		$this->assertFalse(Validation::multiple(array()));
		$this->assertFalse(Validation::multiple(array(0)));
		$this->assertFalse(Validation::multiple(array('0')));

		$this->assertTrue(Validation::multiple(array(0, 3, 4, 5), array('in' => range(0, 10))));
		$this->assertFalse(Validation::multiple(array(0, 15, 20, 5), array('in' => range(0, 10))));
		$this->assertFalse(Validation::multiple(array(0, 5, 10, 11), array('in' => range(0, 10))));
		$this->assertFalse(Validation::multiple(array('boo', 'foo', 'bar'), array('in' => array('foo', 'bar', 'baz'))));

		$this->assertTrue(Validation::multiple(array(0, 5, 10, 11), array('max' => 3)));
		$this->assertFalse(Validation::multiple(array(0, 5, 10, 11, 55), array('max' => 3)));
		$this->assertTrue(Validation::multiple(array('foo', 'bar', 'baz'), array('max' => 3)));
		$this->assertFalse(Validation::multiple(array('foo', 'bar', 'baz', 'squirrel'), array('max' => 3)));

		$this->assertTrue(Validation::multiple(array(0, 5, 10, 11), array('min' => 3)));
		$this->assertTrue(Validation::multiple(array(0, 5, 10, 11, 55), array('min' => 3)));
		$this->assertFalse(Validation::multiple(array('foo', 'bar', 'baz'), array('min' => 5)));
		$this->assertFalse(Validation::multiple(array('foo', 'bar', 'baz', 'squirrel'), array('min' => 10)));

		$this->assertTrue(Validation::multiple(array(0, 5, 9), array('in' => range(0, 10), 'max' => 5)));
		$this->assertFalse(Validation::multiple(array(0, 5, 9, 8, 6, 2, 1), array('in' => range(0, 10), 'max' => 5)));
		$this->assertFalse(Validation::multiple(array(0, 5, 9, 8, 11), array('in' => range(0, 10), 'max' => 5)));

		$this->assertFalse(Validation::multiple(array(0, 5, 9), array('in' => range(0, 10), 'max' => 5, 'min' => 3)));
		$this->assertFalse(Validation::multiple(array(0, 5, 9, 8, 6, 2, 1), array('in' => range(0, 10), 'max' => 5, 'min' => 2)));
		$this->assertFalse(Validation::multiple(array(0, 5, 9, 8, 11), array('in' => range(0, 10), 'max' => 5, 'min' => 2)));
	}
/**
 * testNumeric method
 *
 * @access public
 * @return void
 */
	function testNumeric() {
		$this->assertFalse(Validation::numeric('teststring'));
		$this->assertFalse(Validation::numeric('1.1test'));
		$this->assertFalse(Validation::numeric('2test'));

		$this->assertTrue(Validation::numeric('2'));
		$this->assertTrue(Validation::numeric(2));
		$this->assertTrue(Validation::numeric(2.2));
		$this->assertTrue(Validation::numeric('2.2'));
	}
/**
 * testPhone method
 *
 * @access public
 * @return void
 */
	function testPhone() {
		$this->assertFalse(Validation::phone('teststring'));
		$this->assertFalse(Validation::phone('1-(33)-(333)-(4444)'));
		$this->assertFalse(Validation::phone('1-(33)-3333-4444'));
		$this->assertFalse(Validation::phone('1-(33)-33-4444'));
		$this->assertFalse(Validation::phone('1-(33)-3-44444'));
		$this->assertFalse(Validation::phone('1-(33)-3-444'));
		$this->assertFalse(Validation::phone('1-(33)-3-44'));

		$this->assertFalse(Validation::phone('(055) 999-9999'));
		$this->assertFalse(Validation::phone('(155) 999-9999'));
		$this->assertFalse(Validation::phone('(595) 999-9999'));
		$this->assertFalse(Validation::phone('(555) 099-9999'));
		$this->assertFalse(Validation::phone('(555) 199-9999'));

		$this->assertTrue(Validation::phone('1 (222) 333 4444'));
		$this->assertTrue(Validation::phone('+1 (222) 333 4444'));
		$this->assertTrue(Validation::phone('(222) 333 4444'));

		$this->assertTrue(Validation::phone('1-(333)-333-4444'));
		$this->assertTrue(Validation::phone('1.(333)-333-4444'));
		$this->assertTrue(Validation::phone('1.(333).333-4444'));
		$this->assertTrue(Validation::phone('1.(333).333.4444'));
		$this->assertTrue(Validation::phone('1-333-333-4444'));
	}
/**
 * testPostal method
 *
 * @access public
 * @return void
 */
	function testPostal() {
		$this->assertFalse(Validation::postal('111', null, 'de'));
		$this->assertFalse(Validation::postal('1111', null, 'de'));
		$this->assertTrue(Validation::postal('13089', null, 'de'));

		$this->assertFalse(Validation::postal('111', null, 'be'));
		$this->assertFalse(Validation::postal('0123', null, 'be'));
		$this->assertTrue(Validation::postal('1204', null, 'be'));

		$this->assertFalse(Validation::postal('111', null, 'it'));
		$this->assertFalse(Validation::postal('1111', null, 'it'));
		$this->assertTrue(Validation::postal('13089', null, 'it'));

		$this->assertFalse(Validation::postal('111', null, 'uk'));
		$this->assertFalse(Validation::postal('1111', null, 'uk'));
		$this->assertFalse(Validation::postal('AZA 0AB', null, 'uk'));
		$this->assertFalse(Validation::postal('X0A 0ABC', null, 'uk'));
		$this->assertTrue(Validation::postal('X0A 0AB', null, 'uk'));
		$this->assertTrue(Validation::postal('AZ0A 0AA', null, 'uk'));
		$this->assertTrue(Validation::postal('A89 2DD', null, 'uk'));

		$this->assertFalse(Validation::postal('111', null, 'ca'));
		$this->assertFalse(Validation::postal('1111', null, 'ca'));
		$this->assertFalse(Validation::postal('D2A 0A0', null, 'ca'));
		$this->assertFalse(Validation::postal('BAA 0ABC', null, 'ca'));
		$this->assertFalse(Validation::postal('B2A AABC', null, 'ca'));
		$this->assertFalse(Validation::postal('B2A 2AB', null, 'ca'));
		$this->assertTrue(Validation::postal('X0A 0A2', null, 'ca'));
		$this->assertTrue(Validation::postal('G4V 4C3', null, 'ca'));

		$this->assertFalse(Validation::postal('111', null, 'us'));
		$this->assertFalse(Validation::postal('1111', null, 'us'));
		$this->assertFalse(Validation::postal('130896', null, 'us'));
		$this->assertFalse(Validation::postal('13089-33333', null, 'us'));
		$this->assertFalse(Validation::postal('13089-333', null, 'us'));
		$this->assertFalse(Validation::postal('13A89-4333', null, 'us'));
		$this->assertTrue(Validation::postal('13089-3333', null, 'us'));

		$this->assertFalse(Validation::postal('111'));
		$this->assertFalse(Validation::postal('1111'));
		$this->assertFalse(Validation::postal('130896'));
		$this->assertFalse(Validation::postal('13089-33333'));
		$this->assertFalse(Validation::postal('13089-333'));
		$this->assertFalse(Validation::postal('13A89-4333'));
		$this->assertTrue(Validation::postal('13089-3333'));
	}
/**
 * testSsn method
 *
 * @access public
 * @return void
 */
	function testSsn() {
		$this->assertFalse(Validation::ssn('111-333', null, 'dk'));
		$this->assertFalse(Validation::ssn('111111-333', null, 'dk'));
		$this->assertTrue(Validation::ssn('111111-3334', null, 'dk'));

		$this->assertFalse(Validation::ssn('1118333', null, 'nl'));
		$this->assertFalse(Validation::ssn('1234567890', null, 'nl'));
		$this->assertFalse(Validation::ssn('12345A789', null, 'nl'));
		$this->assertTrue(Validation::ssn('123456789', null, 'nl'));

		$this->assertFalse(Validation::ssn('11-33-4333', null, 'us'));
		$this->assertFalse(Validation::ssn('113-3-4333', null, 'us'));
		$this->assertFalse(Validation::ssn('111-33-333', null, 'us'));
		$this->assertTrue(Validation::ssn('111-33-4333', null, 'us'));
	}
/**
 * testUserDefined method
 *
 * @access public
 * @return void
 */
	function testUserDefined() {
		$validator = new CustomValidator;
		$this->assertFalse(Validation::userDefined('33', $validator, 'customValidate'));
		$this->assertFalse(Validation::userDefined('3333', $validator, 'customValidate'));
		$this->assertTrue(Validation::userDefined('333', $validator, 'customValidate'));
	}

	// function testFile() {
	// 	$this->assertTrue(Validation::file(WWW_ROOT . 'img' . DS . 'cake.icon.gif'));
	// 	$this->assertTrue(Validation::file(WWW_ROOT. 'favicon.ico'));
	// 	$this->assertTrue(Validation::file(WWW_ROOT. 'index.php'));
	// 	$this->assertTrue(Validation::file(WWW_ROOT. 'css' . DS . 'cake.generic.css'));
	// 	$this->assertTrue(Validation::file(TEST_CAKE_CORE_INCLUDE_PATH. 'VERSION.txt'));
	// }
}
?>