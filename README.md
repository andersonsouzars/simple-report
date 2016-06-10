# Simple Report
Framework em PHP para criação de relatórios em PDF.



SimpleReport é um framework escrito em PHP que nos permite gerar relatórios em PDF de forma muito simples, fácil e rápida.

# Como funciona?

1º Você cria o layout do relatório utilizando **Jaspersoft® Studio** ou **iReport Designer**.

2º Você informa o arquivo do layout criado para o Simple Report.

Pronto!

# Exemplo

require_once 'simpleReport/Report.php';

Report::from('seuTemplate.jrxml')->outPut();



# Documentação

Para simplesmente mostrar o relatório no browser basta utilizar isso:

Report::from('seuTemplate.jrxml')->outPut();



Você pode gerar um arquivo para guardar em um diretório:

Report::from('seuTemplate.jrxml')->save('nomeDoArquivo.pdf');



Se preferir fazer o download, utilize:

Report::from('seuTemplate.jrxml')->export('nomeDoArquivo.pdf');


# Elementos implementados

StaticText

TextField

Rectangle

Image

# Paramêtros

SRParameter::set("NAME", "ANDERSON");

Report::from('seuTemplate.jrxml')->outPut();


# Banda Detail
Para interação de dados você pode utilizar tanto o MySQL como um Array.

Exemplo de uso com Array.

$data[] = array('name' => 'Anderson Souza','age' => '27','address' => 'Rio Grande - Brasil');

$data[] = array('name' => 'Hank Chaitchy','age' => '48','address' => 'Istambul - Turquia');

$data[] = array('name' => 'Dolores Rombold','age' => '12','address' => 'Karachi - Paquistao');

$data[] = array('name' => 'Raynor Soulpattle','age' => '25','address' => 'Lagos - Nigeria');

$data[] = array('name' => 'Thelma Brodder  ','age' => '78','address' => 'Xangai - China');


Report::from('seuTemplate.jrxml', SRDataSource::getInstance('Vetor', $data))->outPut();



* Apenas algumas funcionalidades do **Jaspersoft® Studio** foram implementadas.
