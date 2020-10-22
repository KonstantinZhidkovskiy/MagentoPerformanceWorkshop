<?php
declare(strict_types=1);

namespace Webinar\RemoteData\Model\Api;

use Faker\Factory;

/**
 * This is not the class you are looking for.
 */
class Server
{
    /**
     * Produces the ranking of companies.
     *
     * @return array[]
     */
    public function getRank(): array
    {
        $faker = Factory::create();
        $faker->seed(1234);

        $result = [];
        for ($i = 1; $i <= 10; $i++) {
            $result[] = [
                'company' => $faker->company,
                'rank'    => (int)$faker->numberBetween(60, 100)
            ];
        }

        usort($result, function ($a, $b) {
            return $a['rank'] < $b['rank'];
        });

        $faker->seed(null);
        //phpcs:ignore
        $delay = mt_rand(300000, 1000000);
        usleep($delay);

        return $result;
    }
}
