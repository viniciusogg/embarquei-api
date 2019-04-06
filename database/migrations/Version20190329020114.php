<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

// DADOS BÁSICOS PARA PORULAR O BANCO QUANDO OS DADOS FOREM RESETADOS
class Version20190329020114 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');


        // GEOLOCALIZAÇÕES
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("39504157-a148-449f-99e0-8aa113089b04", -8.070750, -37.267320);'); // SERTANIA
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("535e937f-fea7-4960-972c-4d4e6cdb2f34", -7.891030, -37.122749);'); // MONTEIRO
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("a8c401b9-6e94-4e4d-b7d6-43ffaa76ed5b", -7.905446, -37.120141);'); // IFPB
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("1796be9a-bff4-4900-93d9-2626fa88051a", -7.892480, -37.126719);'); // UEPB

        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("7cd1d3e6-1ce0-4919-ade2-d11fb8ad2d69", -8.06990700, -37.26875960);');// IDA PONTO 1
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("293ffe32-106d-4648-b583-3e2a025b3be9", -8.07102688, -37.26792906);');// IDA PONTO 2
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("3c9c81fa-29a4-41cc-9ef9-714103c0f358", -8.07244427, -37.26613998);');// IDA PONTO 3
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("7d18a147-0d85-43b7-af53-48d731bb6b21", -8.07546105, -37.26607561);');// IDA PONTO 4
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("5ede793e-40c7-41ec-b41b-522fe0d8cf6d", -8.07778736, -37.26602197);');// IDA PONTO 5
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("ed625d7d-ad5b-4aa4-a8c8-7f049eba92f2", -8.06983468, -37.26048515);');// IDA PONTO 6
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("321a464f-1de8-4a80-902d-2040155cd661", -8.06983468, -37.26048515);');// VOLTA PONTO 1
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("910f9226-0694-4e97-8a1c-73a106a47976", -8.07778736, -37.26602197);');// VOLTA PONTO 2
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("c22badd2-9ee5-41ee-baf7-773a6f45f313", -8.07546105, -37.26607561);');// VOLTA PONTO 3
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("4a1002b5-6fa7-4fe7-88c5-a593a7c8139c", -8.07244427, -37.26613998);');// VOLTA PONTO 4
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("ad7d89e3-3ba3-4e86-89b0-73621e6ad8f9", -8.07102688, -37.26792906);');// VOLTA PONTO 5
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("2af5a91f-cd2f-4cac-8b3e-f2e0e76155f2", -8.06990700, -37.26875960);');// VOLTA PONTO 6

        // CIDADES
        $this->addSql('INSERT INTO cidades (id, nome, geolocalizacao_id) VALUES ("2114d2e6-f3ca-4dba-9b04-982268d3aa38", "Sertânia", "39504157-a148-449f-99e0-8aa113089b04");');
        $this->addSql('INSERT INTO cidades (id, nome, geolocalizacao_id) VALUES ("54f01880-6401-489b-80e0-eef5ef57e666", "Monteiro", "535e937f-fea7-4960-972c-4d4e6cdb2f34");');


        // ENDEREÇOS
        $this->addSql('INSERT INTO enderecos (id, logradouro, bairro, cidade_id) VALUES ("2582c0db-7c56-4ee4-bf7b-f09f42ab6fb3", "Rua 10", "Centro", "2114d2e6-f3ca-4dba-9b04-982268d3aa38");'); // ENDEREÇO ADMIN
        $this->addSql('INSERT INTO enderecos (id, logradouro, bairro, cidade_id) VALUES ("02f5697f-e912-40e8-844a-44c21558cd0c", "Acesso Rodovia PB 264, S/N", "Vila Santa Maria", "54f01880-6401-489b-80e0-eef5ef57e666");'); // ENDEREÇO IFPB
        $this->addSql('INSERT INTO enderecos (id, logradouro, bairro, cidade_id) VALUES ("140e8994-1c5f-4b01-a119-c0b59d627f7f", "R. Abelardo Pereira dos Santos, 78", "Centro", "54f01880-6401-489b-80e0-eef5ef57e666");'); // ENDEREÇO UEPB


        // INSTITUIÇÕES DE ENSINO
        $this->addSql('INSERT INTO instituicoes_ensino (id, nome, endereco_id, geolocalizacao_id) VALUES ("4861bc24-1480-484b-a811-b8a37d40e6c7", "IFPB - Monteiro", "02f5697f-e912-40e8-844a-44c21558cd0c", "a8c401b9-6e94-4e4d-b7d6-43ffaa76ed5b");'); // IFPB
        $this->addSql('INSERT INTO instituicoes_ensino (id, nome, endereco_id, geolocalizacao_id) VALUES ("2b2c4c33-7026-40a7-a605-c034407b2195", "UEPB - Campus VI", "140e8994-1c5f-4b01-a119-c0b59d627f7f", "1796be9a-bff4-4900-93d9-2626fa88051a");'); // UEPB


        // CURSOS
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("c29fed71-0091-4f0e-8386-738d508d5422", "4861bc24-1480-484b-a811-b8a37d40e6c7", "Análise e Desenvolvimento de Sistemas");');
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("5315a391-7bd2-47f0-bf8f-1de9a1c13ec9", "4861bc24-1480-484b-a811-b8a37d40e6c7", "Construção de Edifícios");');
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("06ee1640-755d-44c6-b698-8b1b55aabc9a", "2b2c4c33-7026-40a7-a605-c034407b2195", "Matemática (licenciatura)");');
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("16cf300e-a00f-4ecf-aac2-331a029c022c", "2b2c4c33-7026-40a7-a605-c034407b2195", "Ciências Contábeis");');
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("45285307-20c6-4784-bd96-0938d7ff3182", "2b2c4c33-7026-40a7-a605-c034407b2195", "Letras Espanhol (licenciatura)");');
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("85f1ab6a-926c-4aed-93d4-16630ef2001d", "2b2c4c33-7026-40a7-a605-c034407b2195", "Português (licenciatura)");');


        // CONTA DE ADMIN
        $this->addSql('INSERT INTO usuarios (id, nome, sobrenome, numero_celular, ativo, password, discr, beta) VALUES ("657d758a-c596-490e-aeae-dfd7b3f814f0", "Secretaria da educação", "Sertânia", "8712345678", true, "$2y$10$SA3f/P4RuNyzY886aMAWmehkxVZXO3k.jFKG8woUHHIAOWJ9aPgFu", "admin", true);');
        $this->addSql('INSERT INTO administradores (id, endereco_id) VALUES ("657d758a-c596-490e-aeae-dfd7b3f814f0", "2582c0db-7c56-4ee4-bf7b-f09f42ab6fb3");');

        // HORARIO TRAJETO
        $this->addSql('INSERT INTO horarios_trajeto (id, partida, chegada) VALUES ("0b204261-bbf8-44d7-8e1d-ca08a5f4d2db", "18:00:00", "18:10:00")');
        $this->addSql('INSERT INTO horarios_trajeto (id, partida, chegada) VALUES ("78c2bd16-f730-4fa4-8e9c-1599c83332c7", "22:00:00", "22:10:00")');

        // ROTA
        $this->addSql('INSERT INTO rotas (id, cidade_id, nome) VALUES ("e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "2114d2e6-f3ca-4dba-9b04-982268d3aa38", "Rota principal");');


        // PONTOS PARADA IDA
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("2430b5f9-aea5-4238-ae53-67447f696368", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "7cd1d3e6-1ce0-4919-ade2-d11fb8ad2d69", "INSS", 1)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("e9fe7367-08c0-49d4-a2fe-e80faa808603", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "293ffe32-106d-4648-b583-3e2a025b3be9", "-", 2)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("b8630d5f-47b2-4da7-9f28-0aedea05ce00", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "3c9c81fa-29a4-41cc-9ef9-714103c0f358", "Escola Jorge de Menezes", 3)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("74eb163b-9933-4f36-8711-c622d6d0a0b7", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "7d18a147-0d85-43b7-af53-48d731bb6b21", "Correios", 4)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("9338a267-050e-47ea-96f4-60f9e6e54f05", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "5ede793e-40c7-41ec-b41b-522fe0d8cf6d", "Rua Velha", 5)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("e99be939-a505-4bb4-ac30-0b3bc2548a7b", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "ed625d7d-ad5b-4aa4-a8c8-7f049eba92f2", "Saída da cidade", 6)');

                                                                                                                                                                            // PONTOS PARADA VOLTA
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("8f0975c4-c963-4254-bc96-ac0db0d35f6b", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "321a464f-1de8-4a80-902d-2040155cd661", "Saída da cidade", 1)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("b1bc0ae4-db52-4630-98b0-f8cc93ef0b18", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "910f9226-0694-4e97-8a1c-73a106a47976", "Rua Velha", 2)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("82f8f4b2-8a39-41bc-b4d8-e05d01358dde", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "c22badd2-9ee5-41ee-baf7-773a6f45f313", "Correios", 3)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("38f47918-78c0-471a-a036-a6d07421f617", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "4a1002b5-6fa7-4fe7-88c5-a593a7c8139c", "Escola Jorge de Menezes", 4)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("d48df875-dc25-41f7-93a2-5c9c6c436551", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "ad7d89e3-3ba3-4e86-89b0-73621e6ad8f9", "-", 5)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("ed0d0e69-c01f-4067-9750-0c2061015960", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "2af5a91f-cd2f-4cac-8b3e-f2e0e76155f2", "INSS", 6)');

        // TRAJETO
        $this->addSql('INSERT INTO trajetos (id, horario_trajeto_id, rota_id, tipo) VALUES ("b685cdbd-f113-4a45-813b-4f8ecbe086c2", "0b204261-bbf8-44d7-8e1d-ca08a5f4d2db", "e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "IDA");');
        $this->addSql('INSERT INTO trajetos (id, horario_trajeto_id, rota_id, tipo) VALUES ("ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "78c2bd16-f730-4fa4-8e9c-1599c83332c7", "e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "VOLTA");');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
