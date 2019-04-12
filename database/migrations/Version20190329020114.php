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
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("cf6f1ffe-cd28-4dcb-a2a1-7f85af7a39d9", -7.889224211010037, -37.119112704429995);'); // INTELECTUS

        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("7cd1d3e6-1ce0-4919-ade2-d11fb8ad2d69", -8.06990700, -37.26875960);'); // IDA PONTO 1
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("293ffe32-106d-4648-b583-3e2a025b3be9", -8.07102688, -37.26792906);'); // IDA PONTO 2
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("3c9c81fa-29a4-41cc-9ef9-714103c0f358", -8.07244427, -37.26613998);'); // IDA PONTO 3
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("7d18a147-0d85-43b7-af53-48d731bb6b21", -8.07546105, -37.26607561);'); // IDA PONTO 4
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("5ede793e-40c7-41ec-b41b-522fe0d8cf6d", -8.07778736, -37.26602197);'); // IDA PONTO 5
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("0c7c0421-519e-4b26-93bc-ea30649de351", -8.06983468, -37.26048515);'); // IDA PONTO 6
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("629e6ece-cb4e-45f5-a0bc-e63dc2994706", -8.02462796111926, -37.23872553667371);'); // IDA PONTO 7
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("ed625d7d-ad5b-4aa4-a8c8-7f049eba92f2", -7.953845937820276, -37.209186023405266);'); // IDA PONTO 8
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("321a464f-1de8-4a80-902d-2040155cd661", -7.904956274069717, -37.12007761001587);'); // IDA PONTO 9
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("9f68e0c6-0738-4424-b23a-b6d12e4f3500", -7.889224211010037, -37.119112704429995);'); // IDA PONTO 10

        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("57106f1c-b14f-465e-9f44-d9293f4daf72", -7.889224211010037, -37.119112704429995);'); // VOLTA PONTO 1
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("910f9226-0694-4e97-8a1c-73a106a47976", -7.904956274069717, -37.12007761001587);'); // VOLTA PONTO 2
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("c22badd2-9ee5-41ee-baf7-773a6f45f313", -7.953845937820276, -37.209186023405266);'); // VOLTA PONTO 3
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("4a1002b5-6fa7-4fe7-88c5-a593a7c8139c", -8.02462796111926, -37.23872553667371);'); // VOLTA PONTO 4
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("9eedad55-8017-45cb-a872-11dd339b0ad8", -8.069967916816545, -37.26062658452247);'); // VOLTA PONTO 5
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("f33a99f2-5f8c-4970-a172-98d80bfda9e0", -8.066994873944829, -37.26494908332825);'); // VOLTA PONTO 6
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("09595c02-8cba-4cff-8372-2b397eedf985", -8.067049299603918, -37.269000928172034);'); // VOLTA PONTO 7
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("a0e5c146-44f5-4266-8cb0-91750926811d", -8.06861283549004, -37.269105031409424);'); // VOLTA PONTO 8
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("65665bbf-9509-4d67-a633-9c39084ca8f2", -8.071100718466724, -37.268201003678826);'); // VOLTA PONTO 9
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("521120c5-6ce9-4967-85fc-820633e6c0e4", -8.073043454067745, -37.265959696827736);'); // VOLTA PONTO 10
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("3f8384f3-729d-439f-a3ad-c787d201919e", -8.075935886202316, -37.26597519621015);'); // VOLTA PONTO 11
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("8fb258b5-f759-4038-9482-2cb9ae7ed5f5", -8.077697072815285, -37.26718604564667);'); // VOLTA PONTO 12
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("d0b4c531-1f41-4873-81fc-433de947b859", -8.08226990881991, -37.26480232662243);'); // VOLTA PONTO 13
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("fdffb027-5a30-4e6e-98d4-9049ad5214b7", -8.072858545563456, -37.27020621299744);'); // VOLTA PONTO 14
        $this->addSql('INSERT INTO geolocalizacoes (id, lat, lng) VALUES ("9751cd11-f37c-4c16-b85a-4134078d4b96", -8.068416095781885, -37.2748221185941);'); // VOLTA PONTO 15


        // CIDADES
        $this->addSql('INSERT INTO cidades (id, nome, geolocalizacao_id) VALUES ("2114d2e6-f3ca-4dba-9b04-982268d3aa38", "Sertânia", "39504157-a148-449f-99e0-8aa113089b04");');
        $this->addSql('INSERT INTO cidades (id, nome, geolocalizacao_id) VALUES ("54f01880-6401-489b-80e0-eef5ef57e666", "Monteiro", "535e937f-fea7-4960-972c-4d4e6cdb2f34");');


        // ENDEREÇOS
        $this->addSql('INSERT INTO enderecos (id, logradouro, bairro, cidade_id) VALUES ("2582c0db-7c56-4ee4-bf7b-f09f42ab6fb3", "Rua 10", "Centro", "2114d2e6-f3ca-4dba-9b04-982268d3aa38");'); // ENDEREÇO ADMIN
        $this->addSql('INSERT INTO enderecos (id, logradouro, bairro, cidade_id) VALUES ("02f5697f-e912-40e8-844a-44c21558cd0c", "Acesso Rodovia PB 264, S/N", "Vila Santa Maria", "54f01880-6401-489b-80e0-eef5ef57e666");'); // ENDEREÇO IFPB
        $this->addSql('INSERT INTO enderecos (id, logradouro, bairro, cidade_id) VALUES ("140e8994-1c5f-4b01-a119-c0b59d627f7f", "R. Abelardo Pereira dos Santos, 78", "Centro", "54f01880-6401-489b-80e0-eef5ef57e666");'); // ENDEREÇO UEPB
        $this->addSql('INSERT INTO enderecos (id, logradouro, bairro, cidade_id) VALUES ("4b375481-205b-4a3d-bbaa-978acc5aae09", "R. Corononel João Santa Cruz, 354", "Centro", "54f01880-6401-489b-80e0-eef5ef57e666");');// ENDEREÇO INTELECTUS


        // INSTITUIÇÕES DE ENSINO
        $this->addSql('INSERT INTO instituicoes_ensino (id, nome, endereco_id, geolocalizacao_id) VALUES ("4861bc24-1480-484b-a811-b8a37d40e6c7", "IFPB - Monteiro", "02f5697f-e912-40e8-844a-44c21558cd0c", "a8c401b9-6e94-4e4d-b7d6-43ffaa76ed5b");'); // IFPB
        $this->addSql('INSERT INTO instituicoes_ensino (id, nome, endereco_id, geolocalizacao_id) VALUES ("2b2c4c33-7026-40a7-a605-c034407b2195", "UEPB - Campus VI", "140e8994-1c5f-4b01-a119-c0b59d627f7f", "1796be9a-bff4-4900-93d9-2626fa88051a");'); // UEPB
        $this->addSql('INSERT INTO instituicoes_ensino (id, nome, endereco_id, geolocalizacao_id) VALUES ("db0819c5-a09a-4bfb-b1b2-78f5c75e46b5", "Centro de ensino Intelectus", "4b375481-205b-4a3d-bbaa-978acc5aae09", "cf6f1ffe-cd28-4dcb-a2a1-7f85af7a39d9");'); // INTELECTUS


        // CURSOS
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("c29fed71-0091-4f0e-8386-738d508d5422", "4861bc24-1480-484b-a811-b8a37d40e6c7", "Análise e Desenvolvimento de Sistemas");'); // IFPB
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("5315a391-7bd2-47f0-bf8f-1de9a1c13ec9", "4861bc24-1480-484b-a811-b8a37d40e6c7", "Construção de Edifícios");'); // IFPB
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("06ee1640-755d-44c6-b698-8b1b55aabc9a", "2b2c4c33-7026-40a7-a605-c034407b2195", "Matemática (licenciatura)");'); // UEPB
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("16cf300e-a00f-4ecf-aac2-331a029c022c", "2b2c4c33-7026-40a7-a605-c034407b2195", "Ciências Contábeis");'); // UEPB
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("45285307-20c6-4784-bd96-0938d7ff3182", "2b2c4c33-7026-40a7-a605-c034407b2195", "Letras Espanhol (licenciatura)");'); // UEPB
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("85f1ab6a-926c-4aed-93d4-16630ef2001d", "2b2c4c33-7026-40a7-a605-c034407b2195", "Português (licenciatura)");'); // UEPB
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("e71ccde2-308c-4e08-882f-2fae5b2d6b17", "db0819c5-a09a-4bfb-b1b2-78f5c75e46b5", "Enfermagem");'); // INTELECTUS
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("8d02c3f3-1054-4f88-8656-09aaa748ed9a", "db0819c5-a09a-4bfb-b1b2-78f5c75e46b5", "Radiologia");'); // INTELECTUS
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("6017282e-9e89-42f3-838c-a490a5898ed3", "db0819c5-a09a-4bfb-b1b2-78f5c75e46b5", "Administração");'); // INTELECTUS
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("7b561005-ffd6-4011-a7f7-d6ee67e28392", "db0819c5-a09a-4bfb-b1b2-78f5c75e46b5", "Agropecuária");'); // INTELECTUS
        $this->addSql('INSERT INTO cursos (id, instituicao_ensino_id, nome) VALUES ("fdb1b487-b51b-4874-aca6-5612c866f071", "db0819c5-a09a-4bfb-b1b2-78f5c75e46b5", "Auxiliar técnico em farmácia");'); // INTELECTUS


        // CONTA DE ADMIN
        $this->addSql('INSERT INTO usuarios (id, nome, sobrenome, numero_celular, ativo, password, discr, beta) VALUES ("657d758a-c596-490e-aeae-dfd7b3f814f0", "Secretaria da educação", "Sertânia", "8712345678", true, "$2y$10$SA3f/P4RuNyzY886aMAWmehkxVZXO3k.jFKG8woUHHIAOWJ9aPgFu", "admin", true);');
        $this->addSql('INSERT INTO administradores (id, endereco_id) VALUES ("657d758a-c596-490e-aeae-dfd7b3f814f0", "2582c0db-7c56-4ee4-bf7b-f09f42ab6fb3");');


        // HORARIO TRAJETO
        $this->addSql('INSERT INTO horarios_trajeto (id, partida, chegada) VALUES ("0b204261-bbf8-44d7-8e1d-ca08a5f4d2db", "18:00:00", "18:10:00")');
        $this->addSql('INSERT INTO horarios_trajeto (id, partida, chegada) VALUES ("78c2bd16-f730-4fa4-8e9c-1599c83332c7", "22:00:00", "22:10:00")');


        // ROTA
        $this->addSql('INSERT INTO rotas (id, cidade_id, nome) VALUES ("e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "2114d2e6-f3ca-4dba-9b04-982268d3aa38", "Rota principal");');


        // INSTITUICAO_ENSINO_ROTA
        $this->addSql('INSERT INTO instituicao_ensino_rota (rota_id, instituicao_ensino_id) VALUES ("e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "4861bc24-1480-484b-a811-b8a37d40e6c7");');
        $this->addSql('INSERT INTO instituicao_ensino_rota (rota_id, instituicao_ensino_id) VALUES ("e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "db0819c5-a09a-4bfb-b1b2-78f5c75e46b5");');


        // TRAJETO
        $this->addSql('INSERT INTO trajetos (id, horario_trajeto_id, rota_id, tipo) VALUES ("b685cdbd-f113-4a45-813b-4f8ecbe086c2", "0b204261-bbf8-44d7-8e1d-ca08a5f4d2db", "e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "IDA");');
        $this->addSql('INSERT INTO trajetos (id, horario_trajeto_id, rota_id, tipo) VALUES ("ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "78c2bd16-f730-4fa4-8e9c-1599c83332c7", "e9e5dcfd-113e-4bc5-b3bd-4540c887e487", "VOLTA");');


        // PONTOS PARADA IDA
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("2430b5f9-aea5-4238-ae53-67447f696368", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "7cd1d3e6-1ce0-4919-ade2-d11fb8ad2d69", "INSS", 1)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("e9fe7367-08c0-49d4-a2fe-e80faa808603", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "293ffe32-106d-4648-b583-3e2a025b3be9", "-", 2)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("b8630d5f-47b2-4da7-9f28-0aedea05ce00", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "3c9c81fa-29a4-41cc-9ef9-714103c0f358", "Escola Jorge de Menezes", 3)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("74eb163b-9933-4f36-8711-c622d6d0a0b7", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "7d18a147-0d85-43b7-af53-48d731bb6b21", "Correios", 4)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("9338a267-050e-47ea-96f4-60f9e6e54f05", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "5ede793e-40c7-41ec-b41b-522fe0d8cf6d", "Rua Velha", 5)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("e99be939-a505-4bb4-ac30-0b3bc2548a7b", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "0c7c0421-519e-4b26-93bc-ea30649de351", "Saída da cidade", 6)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("99d6e33c-8c55-40e4-bee7-d12b3a54ef01", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "629e6ece-cb4e-45f5-a0bc-e63dc2994706", "Sítio", 7)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("b2675638-3e68-4e2b-830e-400edfa0ad5a", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "ed625d7d-ad5b-4aa4-a8c8-7f049eba92f2", "Pernambuquinho", 8)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("a96fa654-29c9-495a-a6b7-255c75e97d15", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "321a464f-1de8-4a80-902d-2040155cd661", "IFPB - Monteiro", 9)');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("2c47fc01-c3db-4f86-8f08-c54e47b60f7c", "b685cdbd-f113-4a45-813b-4f8ecbe086c2", "9f68e0c6-0738-4424-b23a-b6d12e4f3500", "Centro de ensino Intelectus", 10)');

        // PONTOS PARADA VOLTA
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("8f0975c4-c963-4254-bc96-ac0db0d35f6b", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "57106f1c-b14f-465e-9f44-d9293f4daf72", "Centro de ensino Intelectus", 1);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("b1bc0ae4-db52-4630-98b0-f8cc93ef0b18", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "910f9226-0694-4e97-8a1c-73a106a47976", "IFPB", 2);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("82f8f4b2-8a39-41bc-b4d8-e05d01358dde", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "c22badd2-9ee5-41ee-baf7-773a6f45f313", "Pernambuquinho", 3);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("38f47918-78c0-471a-a036-a6d07421f617", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "4a1002b5-6fa7-4fe7-88c5-a593a7c8139c", "Sítio Jorge de Menezes", 4);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("d48df875-dc25-41f7-93a2-5c9c6c436551", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "9eedad55-8017-45cb-a872-11dd339b0ad8", "Saída da cidade", 5);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("ed0d0e69-c01f-4067-9750-0c2061015960", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "f33a99f2-5f8c-4970-a172-98d80bfda9e0", "Rodoviária", 6);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("6cd06781-23da-4d67-9f83-68d31ccf151d", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "09595c02-8cba-4cff-8372-2b397eedf985", "Escola Etelvino", 7);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("44ae7920-19bc-497e-b032-621524f1c45e", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "a0e5c146-44f5-4266-8cb0-91750926811d", "Praça Vila Cohab", 8);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("1c225b88-5a8f-4705-8149-aab5f8955cdb", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "65665bbf-9509-4d67-a633-9c39084ca8f2", "Cruzamento", 9);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("0d74c802-2a6f-4a29-95f6-bc6876d4c3fb", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "521120c5-6ce9-4967-85fc-820633e6c0e4", "Mercado Nordeste", 10);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("4a868f2a-2a06-4e45-836a-16a8b8110ae2", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "3f8384f3-729d-439f-a3ad-c787d201919e", "Rádio", 11);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("de97c3c8-2dea-4722-8951-6661201b5174", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "8fb258b5-f759-4038-9482-2cb9ae7ed5f5", "Rua velha", 12);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("bf8995a2-51d0-4209-a2c6-7f2ea345ed9a", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "d0b4c531-1f41-4873-81fc-433de947b859", "Alto do rio branco", 13);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("60a8ca94-f48a-4502-9700-27c175e31120", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "fdffb027-5a30-4e6e-98d4-9049ad5214b7", "Casa das balanças", 14);');
        $this->addSql('INSERT INTO pontos_parada (id, trajeto_id, geolocalizacao_id, nome, ordem) VALUES ("20c14d96-6ab4-43f2-804b-3939a295247a", "ca2dfc27-d237-4217-a9e1-9dfe0b0ca099", "9751cd11-f37c-4c16-b85a-4134078d4b96", "Posto de gasolina, hospital", 15);');


        // OAUTH
        $this->addSql('INSERT INTO oauth_clients (id, name, secret, redirect, personal_access_client, password_client, revoked, created_at, updated_at) VALUES (1, "Embarquei Personal Access Client", "jbQTcRskNUQZBpbF6UMWJ4cSdFIz17jcDWaTpKb2", "http://localhost", 1, 0, 0, "2019-03-31 22:16:05", "2019-03-31 22:16:05");');
        $this->addSql('INSERT INTO oauth_clients (id, name, secret, redirect, personal_access_client, password_client, revoked, created_at, updated_at) VALUES (2, "Embarquei Password Grant Client", "qbGBIpdO9OdXlYf1hoLHO1BWtUGeXgA9qcEN8Vqz", "http://localhost", 0, 1, 0, "2019-03-31 22:16:05", "2019-03-31 22:16:05");');
        $this->addSql('INSERT INTO oauth_personal_access_clients (id, client_id, created_at, updated_at) VALUES (1, 1, "2019-03-31 22:16:05", "2019-03-31 22:16:05");');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
