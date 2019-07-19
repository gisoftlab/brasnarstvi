<?php

namespace App\Test;

use App\Service\CalendarService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalendarTest extends WebTestCase
{


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $this->assertTrue(true);
    }

    /**
     * @dataProvider providerValidation
     */
    public function test_calendar_validation($source, $value)
    {

        self::bootKernel();
        $container = self::$container;
        $calendarService = $container->get(CalendarService::class);

        try {
            $calendarService->getDayByDate($source);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), $value);
        }
    }

    public function providerValidation()
    {
        return array(
            ['23.1.1990', 'Day has to be between 1 than 21 in regular month.'],
            ['1.14.1990', 'Month has to be between 1 than 13'],
            ['22.1.1990', 'Day has to be between 1 than 21 in regular month.'],
            ['23.2.1990', 'Day has to be between 1 than 22 in odd month.'],
            ['23.13.1995', 'Day has to be between 1 than 21 in leap year.'],
        );
    }

    /**
     * @dataProvider provider
     */
    public function test_calendar($source, $value)
    {

        self::bootKernel();
        $container = self::$container;
        $calendarService = $container->get(CalendarService::class);


        $this->assertEquals($calendarService->getDayByDate($source), $value);
    }

    public function provider()
    {
        return array(
            ['1.1.1990', 'Monday'],
            ['1.2.1990', 'Tuesday'],
            ['1.3.1990', 'Tuesday'],
            ['1.4.1990', 'Wednesday'],
            ['1.5.1990', 'Wednesday'],
            ['1.6.1990', 'Thursday'],
            ['1.7.1990', 'Thursday'],
            ['1.8.1990', 'Friday'],
            ['1.9.1990', 'Friday'],
            ['1.10.1990', 'Saturday'],
            ['1.11.1990', 'Saturday'],
            ['1.12.1990', 'Sunday'],
            ['1.13.1990', 'Sunday'],
            ['1.1.1991', 'Sunday'],
            ['1.2.1991', 'Monday'],
            ['1.3.1991', 'Monday'],
            ['1.4.1991', 'Tuesday'],
            ['1.5.1991', 'Tuesday'],
            ['1.6.1991', 'Wednesday'],
            ['1.7.1991', 'Wednesday'],
            ['1.8.1991', 'Thursday'],
            ['1.9.1991', 'Thursday'],
            ['1.10.1991', 'Friday'],
            ['1.11.1991', 'Friday'],
            ['1.12.1991', 'Saturday'],
            ['1.13.1991', 'Saturday'],
            ['1.2.1991', 'Monday'],
            ['1.3.1993', 'Monday'],
            ['1.5.1993', 'Tuesday'],
            ['1.5.1996', 'Monday'],
            ['1.5.2001', 'Sunday'],
            ['1.5.2011', 'Friday'],
        );
    }
}
