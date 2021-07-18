<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeighborhoodsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $neighborhoods = $this->neighborhoods();
        foreach ($neighborhoods as $neighborhood){
            DB::table('neighborhoods')->insert([
                'city_id'    => $neighborhood['city_id'],
                'name'       => $neighborhood['name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function neighborhoods()
    {
        return [
            [
                "city_id" => 3516200,
                "name"    => "Vila Hípica"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Amazonas"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Núcleo Agrícola Alpha"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque Universitário"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Noêmia"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Centro"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Santa Cruz"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Meireles"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial São Jerônimo"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Belvedere Bandeirante"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Integração"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Prolongamento Jardim Ângela Rosa"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Palestina"
            ],
            [
                "city_id" => 3516200,
                "name"    => "São José"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque Moema"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Rezende"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Santo Agostinho"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Paraíso"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Industrial"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Estação"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Zanetti"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque das Esmeraldas"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Chácara Santo Antônio"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Veneza"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Três Colinas"
            ],
            [
                "city_id" => 3516200,
                "name"    => "São Joaquim"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Oswaldo Maciel"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Barão"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Consolação"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Aparecida"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Santana"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Colina do Espraiado"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Brasilândia"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Palermo"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Piratininga 2"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Baldassari"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Paulistano"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Cambuí"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Esplanada Primo Meneghetti 2"
            ],
            [
                "city_id" => 3516200,
                "name"    => "City Petrópolis"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Boa Esperança"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim João Liporoni"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Portinari"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque Vicente Leporace 1"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Prologamento Jardim Doutor Antônio Petráglia"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Prolongamento Jardim Flórida"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Prolongamento Jardim Lima"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Recanto Elimar"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Santa Terezinha"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Santos Dumont"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Totoli"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Éden"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim São Vicente de Paula"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Aeroporto 2"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim das Palmeiras"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Francano"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Luiza"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Luiza 2"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Paineiras"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Paraty"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Piratininga"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim São Luiz 2"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Miramontes"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque São Jorge"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Ana Dorothéa"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Jardim Vera Cruz"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Nosso Lar"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Formosa"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Scarabucci"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Village Santa Georgina"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Higienópolis"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Califórnia"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Conceição Leite"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Flórida"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Maria Rosa"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Martins"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Planalto"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Pulicano"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Redentor"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim São Gabriel"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim São Luiz"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Jardim Tropical"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque do Horto"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque Doutor Carrão"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque  Franville"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Parque Residencial Santa"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Prolongamento Vila Industrial"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Prolongamento Vila Santa Cruz"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial Olivito"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Residencial São Tomaz"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Chico Júlio"
            ],
            [
                "city_id" => 3516200,
                "name"    => "Vila Pandolfo"
            ]
        ];
    }
}
