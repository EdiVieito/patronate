# Proyecto fin de ciclo (Patrónate)

## Descripción

**Patrónate** é un portal onde realizar cursos de costura. En cada curso existirá unha ferramenta online para realizar patróns a medida,para descárgalos e imprimilos posteriormente.

En cada curso existirán instruccións para realizar unha prenda. Como cortar, coser... Ademáis existirá un botón para descargar os patróns coas medidas do usuario.

## Instalación / Puesta en marcha

Para poder despregar este proxecto ñe preciso ter preparado o entorno co alomenos Composer, PHP 7.1(Mellor 8.1) e unha base de datos MariaDB. Para  aprimeira posta en marcha accede co ususario **edivieito@gmail.com** ou **info@patronate.eu** e contrasinal **abc123..**

### Instalación nun servidor
1. Carga o teu código ao servidor de produción;
2. Instala as dependencias do teu vendro (normalmente faise a través de Composer e pódese facer antes de cargar);
3. Crea BBDD e importa as táboas dende patronate.sql
3. Modifica o arquivo .env cos datos da BBDD;

### Instalación nun hosting compartido
1. O primeiro paso será crear a base de datos Maria DB e importar as táboas do arquivo **Patronate.sql**
2. Clonamos o proxecto na raíz. Este proxecto está preparado tamén para aloxarse en hostings compartidos. Polo que se se está instalando nun hosting compartido, clonaremos   a carpeta patronate no directorio wwww. Podemos clonar o vendor ou se temos acceso a composer instalado despoois do clonado.
3. Modifica o arquivo .env cos datos de acceso da túa base de datos e se está nun hosting compartido modifica tamén a variable **UPLOAD_DIR**. Para que funcione tamén tes un arquivo **.HTACCESS** para que fai as redireccións necesarias.
Para que funcione o editor WYSIWYG tamñen é necesario editar o arquivo fos_ckeditor.yml.

## Uso

"Crear os teus propios patróns e moi sinxelo. Rexístrate; introduce as túas medidas e entra no curso que máis te interese. Nel poderás ver tódolos pasos para a confección da túa prenda, como descargar os patróns personalizados para que che quede coma un guante"


## Sobre o autor

Centrado actualmente en deseño web e UX aínda que sempre alerta de novos retos e oportunidades que me permitan aprender e desenvolver o meu espírito crítico.

www.edivieito.es

## Licencia

[MIT License](LICENSE)


## Índice

1. Anteproxecto
    * 1.1. [Idea](doc/templates/1_idea.md)
    * 1.2. [Necesidades](doc/templates/2_necesidades.md)
2. [Análise](doc/templates/3_analise.md)
3. [Planificación](doc/templates/4_planificacion.md)
4. [Deseño](doc/templates/5_deseño.md)
5. [Implantación](doc/templates/6_implantacion.md)


## Guía de contribución

E un proxecto, fácilmente ampliable. Como melloras que se puidesen engadir nun futuro:

* Sistema de chat en liña para falar entre profesores e alumnos
* Foro online no que compartir e punturar os proxectos persoais
* Adición doutros perfís con outras medidas
* Ferramenta para clacular os metros de tea necesaria
* Integrar pasarelas de pago
* Automatización da creación de patróns
* ...

## Links

Para a realización deste proxecto fixóse uso das seguintes librerías e plugins:
* [Meyfa/php-svg](https://github.com/meyfa/php-svg)
* [FPDF](http://www.fpdf.org/)
* [CKEditor](https://ckeditor.com/)