<?php
/**
 * 专题页
 *
 * 
 */

defined('InShopNC') or exit('Access Invalid!');

class ztyControl extends BaseHomeControl {
    //const PAGESIZE = 16;
    public function app_indexOp() {
        
            Tpl::showpage('zty.app');
        }
    public function milk_indexOp() {
        
            Tpl::showpage('zty.milk');
        }
    public function europe_indexOp() {
        
            Tpl::showpage('zty.europe');
        }

    public function two_years_indexOp() {
        
            Tpl::showpage('zty.2years');
        }
    public function two_eleven_indexOp() {
        
            Tpl::showpage('zty.1111');
        }
    public function two_twelve_indexOp() {
        
            Tpl::showpage('zty.1212');
        }
    public function vdayOp() {

        Tpl::showpage('zty.VDay');
    }
	 public function womenDayOp() {

        Tpl::showpage('zty.38');
    }
	public function dijiaOp() {

        Tpl::showpage('zty.dijia');
    }
}