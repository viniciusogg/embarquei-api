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
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
