<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Fpdf\Fpdf;
use SVG\SVG;
use SVG\Nodes\Shapes\SVGPath;
use SVG\Nodes\Shapes\SVGLine;

class PatronBomberController extends AbstractController
{
    //Metodo para recuperar las medidas
    public function medidas()
    {
        //TODO comprobar que estan cubiertas
        $medidas = $this->getUser()->getMedidas();
        //Recuperamos las medidas y añadimos las modificaciones oportunas
        $ancho_espalda = ($medidas->getAnchoEspalda()/2) * 10;
        $contorno_busto = ($medidas->getContornoBusto()/4) * 10;
        $cintura = ($medidas->getCintura()/4) * 10;
        $cadera = ($medidas->getCadera()/4) * 10;
        $ancho_manga = ($medidas->getAnchoManga()/2) * 10;
        $largo_manga = ($medidas->getLargoManga()) * 10;
        $punho = ($medidas->getContornoPunho()/2) * 10;
        $cuello = ($medidas->getContornoCuello()/6) * 10;
        $talle_delantero = ($medidas->getTalleDelantero()) * 10;
        $talle_espalda = ($medidas->getTalleEspalda()) * 10;

        return [$ancho_espalda,$contorno_busto,$cintura,$cadera,$ancho_manga,$largo_manga,$punho,$cuello,$talle_delantero,$talle_espalda];
    }
  

    //Patrón delantero vector
    //Para ahorrar papel meto tb la vista
    public function PatronDelanteroVector() 
    {
        //Medidas
        list($ancho_espalda,$contorno_busto,$cintura,$cadera,$ancho_manga,$largo_manga,$punho,$cuello,$talle_delantero,$talle_espalda) = $this->medidas();
        //Lienzo
        $im = new SVG($contorno_busto+30, $largo_manga);
        $doc = $im->getDocument();
        $doc->addChild((new SVGLine($cuello,0,$ancho_espalda ,40))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine($contorno_busto,240 ,$contorno_busto+30,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(0,$largo_manga,$contorno_busto+30,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(1,($cuello+10),1,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(0,$largo_manga-1,$contorno_busto+30,$largo_manga-1))->setStyle('stroke', '#000'));
        //Cuello
        $curvaCuello = "M". 0 .",". ($cuello+10) ." C". ($cuello/2) .",". ($cuello+10) ." ". $cuello .",". ($cuello/2) ." ". $cuello .",". 0;
        $doc->addChild((new SVGPath($curvaCuello))->setStyle('stroke', '#000')->setStyle('fill', 'none'));
        //Sisa 20
        $sisa = "M". $ancho_espalda .",". 40 ." C". ($ancho_espalda-50).",". 140 ." ". ($ancho_espalda-25) .",". 240 ." ". $contorno_busto .",". 240;
        $doc->addChild((new SVGPath($sisa))->setStyle('stroke', '#000')->setStyle('fill', 'none'));

        //Razones trigonométricas
        $hipotenusa = sqrt(pow(70,2)+ pow($ancho_espalda-$cuello,2));
        $y = 70*(40/$hipotenusa);
        $x = 70*(($ancho_espalda-$cuello)/$hipotenusa);
         //Curva vista
        $vista = "M". $x+$cuello .",". $y ." C". ($x+$cuello-($cuello/2)).",". 140 ." ". 70 .",". $largo_manga/2 ." ". 70 .",". $largo_manga;
        $doc->addChild((new SVGPath($vista))->setStyle('stroke', '#ff0000')->setStyle('fill', 'none'));

        $xmlString = $im->toXMLString();
        return $xmlString;
    } 

    //Patrón trasero vector
    #[Route('/patron/bomber/trasero', name: 'app_patron_trasero_bomber')]
    public function PatronTraseroVector() 
    {
        //Medidas
        list($ancho_espalda,$contorno_busto,$cintura,$cadera,$ancho_manga,$largo_manga,$punho,$cuello,$talle_delantero,$talle_espalda) = $this->medidas();
        //Lienzo
        $im = new SVG($contorno_busto+30, $largo_manga);
        $doc = $im->getDocument();
        $doc->addChild((new SVGLine($cuello,0,$ancho_espalda ,40))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine($contorno_busto,240 ,$contorno_busto+30,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(0,$largo_manga,$contorno_busto+30,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(1,15,1,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(0,$largo_manga-1,$contorno_busto+30,$largo_manga-1))->setStyle('stroke', '#000'));
        //Cuello
        $curvaCuello = "M". 0 .",". 15 ." C". ($cuello/2) .",". 15 ." ". $cuello .",". 10 ." ". $cuello .",". 0;
        $doc->addChild((new SVGPath($curvaCuello))->setStyle('stroke', '#000')->setStyle('fill', 'none'));
        //Sisa 20
        $sisa = "M". $ancho_espalda .",". 40 ." C". ($ancho_espalda-30).",". 140 ." ". ($ancho_espalda-15) .",". 240 ." ". $contorno_busto .",". 240;
        $doc->addChild((new SVGPath($sisa))->setStyle('stroke', '#000')->setStyle('fill', 'none'));
       //Razones trigonométricas
       $hipotenusa = sqrt(pow(70,2)+ pow($ancho_espalda-$cuello,2));
       $y = 70*(40/$hipotenusa);
       $x = 70*(($ancho_espalda-$cuello)/$hipotenusa);
       //vista
       $curvaCuello = "M". $cuello+$x .",". $y ." C". ($cuello+$x/2) .",". 50 ." ". 85 .",". $cuello ." ". 0 .",". 85;
       $doc->addChild((new SVGPath($curvaCuello))->setStyle('stroke', '#ff0000')->setStyle('fill', 'none'));

        $xmlString = $im->toXMLString();
        return $xmlString;
    } 

    //Pintar manga Bomber
    #[Route('/patron/bomber/manga', name: 'app_patron_manga_bomber')]
    public function PatronMangaVector() 
    {
        //Medidas
        list($ancho_espalda,$contorno_busto,$cintura,$cadera,$ancho_manga,$largo_manga,$punho,$cuello,$talle_delantero,$talle_espalda) = $this->medidas();
        //Lienzo
        $im = new SVG(200, $largo_manga);
        $doc = $im->getDocument();
        $doc->addChild((new SVGLine(0,160-15,200-$punho,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(200-$punho,$largo_manga,200,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(200-1,0,200-1,$largo_manga))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(200-$punho,$largo_manga-1,200,$largo_manga-1))->setStyle('stroke', '#000'));

        //Sisa 20
        $sisa = "M". 0 .",". (160-15) ." C". 100 .",". (160-15) ." ". 100 .",". 0 ." ". 200 .",". 0;
        $doc->addChild((new SVGPath($sisa))->setStyle('stroke', '#000')->setStyle('fill', 'none'));

        $xmlString = $im->toXMLString();
        return $xmlString;
    } 

    //Pintar puño Bomber
    #[Route('/patron/bomber/punho', name: 'app_patron_punho_bomber')]
    public function PatronPunhoVector()
    {
        //Medidas
        list($ancho_espalda,$contorno_busto,$cintura,$cadera,$ancho_manga,$largo_manga,$punho,$cuello,$talle_delantero,$talle_espalda) = $this->medidas();
        //Lienzo
        $im = new SVG(70,$punho*2);
        $doc = $im->getDocument();
        $doc->addChild((new SVGLine(1,1,70,1))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(69,1,69,$punho*2))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(69,($punho*2)-1,1,($punho*2)-1))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(1,$punho*2,1,0))->setStyle('stroke', '#000'));
        $xmlString = $im->toXMLString();
        return $xmlString;
    } 
    
    //Pintar cintura Bomber
    #[Route('/patron/bomber/cintura', name: 'app_patron_cintura_bomber')]
    public function PatronCinturaVector() 
    {
        //Medidas
        list($ancho_espalda,$contorno_busto,$cintura,$cadera,$ancho_manga,$largo_manga,$punho,$cuello,$talle_delantero,$talle_espalda) = $this->medidas();
        //Lienzo
        $im = new SVG(70,$contorno_busto*2);
        $doc = $im->getDocument();
        $doc->addChild((new SVGLine(1,1,70,1))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(69,1,69,$contorno_busto*2))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(69,($contorno_busto*2)-1,1,($contorno_busto*2)-1))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(1,$contorno_busto*2,1,0))->setStyle('stroke', '#000'));

        $xmlString = $im->toXMLString();
        return $xmlString;
    }

    //Pintar cuello Bomber
    #[Route('/patron', name: 'patron')]
    public function PatronCuelloVector() 
    {
        //Medidas
        list($ancho_espalda,$contorno_busto,$cintura,$cadera,$ancho_manga,$largo_manga,$punho,$cuello,$talle_delantero,$talle_espalda) = $this->medidas();
        
        $largo_cuello = 2*M_PI*($cuello+10);

        //Lienzo
        $im = new SVG($largo_cuello/2, 70);
        $doc = $im->getDocument();
        //vista
        $curvaCuello = "M". 0 .",". 35 ." C". 35 .",". 70 ." ". 35 .",". 70 ." ". 70 .",". 70;
        $doc->addChild((new SVGPath($curvaCuello))->setStyle('stroke', '#000')->setStyle('fill', 'none'));
        $curvaCuello = "M". 0 .",". 35 ." C". 35 .",". 0 ." ". 35 .",". 0 ." ". 70 .",". 0;
        $doc->addChild((new SVGPath($curvaCuello))->setStyle('stroke', '#000')->setStyle('fill', 'none'));
        $doc->addChild((new SVGLine(70,1,$largo_cuello/2,1))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(70,69,$largo_cuello/2,69))->setStyle('stroke', '#000'));
        $doc->addChild((new SVGLine(($largo_cuello/2)-1,0,($largo_cuello/2)-1,70))->setStyle('stroke', '#000'));
        $xmlString = $im->toXMLString();
        return $xmlString;
    } 

   
    #[Route('/patron/bomber/pdf', name: 'app_patron_pdf_bomber')]
    public function patronBomberPdf(): Response
    {   
        //Comprobar is tiene permiso para el patrón
        $permiso = false;
        $cursosUserLogueado = $this->getUser()->getCursosCostura();
        //En este caso la bomber es el id = 1
        foreach ($cursosUserLogueado as $curso){
            if($curso->getId()==1){
            $permiso = true;
            }
        }

        if (!$permiso) {
            //throw $this->createAccessDeniedException();
            $this->addFlash('error', 'No tienes acceso para descargar ese patrón');
            return $this->redirectToRoute('user_datos');
        }else{

            $file = fopen("log.txt", "w");
            fwrite($file, 'Memoria antes array : ' . round(memory_get_usage()/1024,2).' KB' . PHP_EOL);
        $patronesBomber =[
            'Patron Delantero'=>$this->PatronDelanteroVector(),
            'Patron Trasero'=>$this->PatronTraseroVector(),
            'Patron Manga'=>$this->PatronMangaVector(),
            'Patron Puño'=>$this->PatronPunhoVector(),
            'Patron Cintura'=>$this->PatronCinturaVector(),
            'Patron Cuello'=>$this->PatronCuelloVector(),
        ];
        
        //Medidas
        $medidas = $this->medidas();
        
        $vacio = false;
        foreach ($medidas as $medida){
            if($medida==''|$medida ==null){
                $vacio = true;
            }
        }
        $file = fopen("log.txt", "w");
        //Si tengo todas las medidas hago el patrón
        if(!$vacio){
            $pdf = new Fpdf();
        foreach ($patronesBomber as $key => $parte) {
            $this->patronPdf($parte,$key,$file,$pdf);
        }
        //Guardo el PDF del patrón
        $pdf->Output();

        unset($patronesBomber);
        fclose($file);
        
        $response = new Response($this->renderView('patron_bomber/index.png.twig'),200);
        
        //$response->headers->set('Content-Type','application/pdf');
        return $response;
        }else{
            $this->addFlash('success', 'Necesitas introducir todas tus medidas');
                return $this->redirectToRoute('app_medidas');
        }
    }
}

    //Método para pintar la miniatura de patrones 
    public function mapaPatrones($numeroHojasX,$numeroHojasY,$key)
    {   
            
            $anchoMiniatura = $numeroHojasX*105;
            $altoMiniatura = $numeroHojasY*148;
            $imagen_patron = $_SERVER['DOCUMENT_ROOT'].$_SERVER['UPLOAD_DIR'].$key.'.jpeg';
            // Get new sizes
            list($width, $height) = getimagesize($imagen_patron);
            $newwidth = $width /20;
            $newheight = $height /20;
            //Reescalamos la imagen que ya hay
            $miniatura = imagescale(imagecreatefromjpeg($imagen_patron),$newwidth,$newheight,1);
            $rasterImage = imagecreatetruecolor($anchoMiniatura, $altoMiniatura);
            $blanco = imagecolorallocate($rasterImage, 255, 255, 255);
            imagefill($rasterImage, 0, 0, $blanco);
            $miniatura = imagecopy($rasterImage,$miniatura, 0, 0, 0, 0, $newwidth, $newheight);
            $negro = imagecolorallocate($rasterImage, 0, 0, 0);

            //Marcamos el cuadrado
            imageline($rasterImage,1,1,1,$altoMiniatura,$negro);
            imageline($rasterImage,$anchoMiniatura-1,1,$anchoMiniatura-1,$altoMiniatura,$negro);
            imageline($rasterImage,1,1,$anchoMiniatura,1,$negro);
            imageline($rasterImage,1,$altoMiniatura-1,$anchoMiniatura,$altoMiniatura-1,$negro);

            //Pintar lineas y números
            $contador =1;
            for ($j=0; $j < $numeroHojasY; $j++) { 
                imageline($rasterImage,0,$j*148,$anchoMiniatura,$j*148,$negro);
                for ($i=0; $i < $numeroHojasX; $i++) { 
                    imagestring($rasterImage,10,$i*105+(105/2),$j*148+(148/2) ,$contador, $negro);
                    imageline($rasterImage,$i*105,0,$i*105,$altoMiniatura,$negro);
                    $contador++;
                }
            }
            
            imagejpeg($rasterImage,'miniatura'.$key.'.jpeg');
    }

    //Método para pintar el patrón
    public function patronPdf($parte,$key,$file,$pdf)
    {
        $doc = SVG::fromString($parte)->getDocument();
     
        //PARTE DE RASTERIZAR
        $ancho = $doc->getWidth();
        $alto = $doc->getHeight();
        unset($doc);
        //ESTO ES LO QUE MÁS CONSUME
        $imRaster = imagejpeg(SVG::fromString($parte)->toRasterImage($ancho*10, $alto*10,'#FFFFFF'),$key.'.jpeg');
        //Ruta del patron
        list($ancho, $alto, $tipo, $atributos) = getimagesize($_SERVER['DOCUMENT_ROOT'].$_SERVER['UPLOAD_DIR'].$key.'.jpeg');
        $numeroHojasX = ceil($ancho/2100);
        $numeroHojasY = ceil($alto/2970);
    
        $contador =1;
        for ($j=0; $j < $numeroHojasY; $j++) { 
            for ($i=0; $i < $numeroHojasX; $i++) { 
                $pdf->AddPage();
                $pdf->Image($_SERVER['DOCUMENT_ROOT'].$_SERVER['UPLOAD_DIR'].$key.'.jpeg',0-($i*210),(0-$j*297),$ancho/10,$alto/10);
                $pdf->SetFont('Arial','B',16);
                $pdf->Cell(40,10,utf8_decode($key).' '.$contador);
                $contador++;
            }
        }

        //En la ultima hoja incluyo la miniatura
        $this->mapaPatrones($numeroHojasX,$numeroHojasY,$key);
        list($anchoMiniatura, $altoMiniatura, $tipo, $atributos) = getimagesize($_SERVER['DOCUMENT_ROOT'].$_SERVER['UPLOAD_DIR'].'miniatura'.$key.'.jpeg');
        $pdf->Image($_SERVER['DOCUMENT_ROOT'].$_SERVER['UPLOAD_DIR'].'miniatura'.$key.'.jpeg',190-(($anchoMiniatura*2)/10),260-(($altoMiniatura*2)/10));

        //Me cargo la imagen usada
        unlink($_SERVER['DOCUMENT_ROOT'].$_SERVER['UPLOAD_DIR'].$key.'.jpeg');
        unlink($_SERVER['DOCUMENT_ROOT'].$_SERVER['UPLOAD_DIR'].'miniatura'.$key.'.jpeg');
        
        
        //Voy a escribirlo en un fichero de texto
        fwrite($file, 'Memoria : ' . round(memory_get_usage()/1024).' KB' . PHP_EOL);
    }
}