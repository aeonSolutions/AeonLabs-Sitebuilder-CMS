
// Carrega Provincia

function CargaProvincias()
  {
    var i=0;
    var longitud;
    var o= new Array;
    var indice=0;
    indice= (document.Register.pais.selectedIndex);
    
    //CASO DE ESPAÑA
    if (indice== 3)
     {

	  document.Register.provincia.length=1;

      longitud = (document.Register.provincia.length);
       for (j=0; j<longitud; j++)
         { 
           o[j]=new Option("","");
           document.Register.provincia.options[j]=o[j];
         }      

      o[i++]=new Option("[Elige una provincia]","");
	  o[i++]=new Option("-------------------------------","");
      o[i++]=new Option("Madrid", "M");      
      o[i++]=new Option("Barcelona", "B");
      o[i++]=new Option("&aacute;lava", "VI");
      o[i++]=new Option("Albacete", "AB");
      o[i++]=new Option("Alicante", "A");
      o[i++]=new Option("Almeria", "AL");
      o[i++]=new Option("Asturias", "O");
      o[i++]=new Option("Avila", "AV");
      o[i++]=new Option("Badajoz", "BA");
      o[i++]=new Option("Baleares", "IB");
      o[i++]=new Option("Burgos", "BU");
      o[i++]=new Option("Caceres", "CC");
      o[i++]=new Option("C&aacute;diz", "CA");
      o[i++]=new Option("Cantabria", "S");
      o[i++]=new Option("Castellón", "CS");
      o[i++]=new Option("Ceuta", "CE");
      o[i++]=new Option("Ciudad Real", "CR");
      o[i++]=new Option("Córdoba", "CO");
      o[i++]=new Option("Cuenca", "CU");
      o[i++]=new Option("Girona", "GI");
      o[i++]=new Option("Granada", "GR");
      o[i++]=new Option("Guadalajara", "GU");
      o[i++]=new Option("Guipúzcua", "SS");
      o[i++]=new Option("Huelva", "H");
      o[i++]=new Option("Huesca", "HU");
      o[i++]=new Option("Jaen", "J");
      o[i++]=new Option("Coruña", "C");
      o[i++]=new Option("La Rioja", "LO");
      o[i++]=new Option("Las Palmas", "GC");
      o[i++]=new Option("Leon", "LE");
      o[i++]=new Option("Lleida", "L");
      o[i++]=new Option("Lugo", "LU");
      o[i++]=new Option("M&aacute;laga", "MA");
      o[i++]=new Option("Melilla", "ME");
      o[i++]=new Option("Murcia", "MU");      
      o[i++]=new Option("Navarra", "NA");
      o[i++]=new Option("Ourense", "OU");
      o[i++]=new Option("Palencia", "P");
      o[i++]=new Option("Pontevedra", "PO");
      o[i++]=new Option("Salamanca", "SA");
      o[i++]=new Option("Tenerife", "TF");
      o[i++]=new Option("Segovia", "SG");
      o[i++]=new Option("Sevilla", "SE");      
      o[i++]=new Option("Soria", "SO");
      o[i++]=new Option("Tarragona", "T");
      o[i++]=new Option("Teruel", "TE");
      o[i++]=new Option("Toledo", "TO");
      o[i++]=new Option("Valencia", "V");
      o[i++]=new Option("Valladolid", "VA");
      o[i++]=new Option("Vizcaya", "BI");
      o[i++]=new Option("Zamora", "ZA");
      o[i++]=new Option("Zaragoza", "Z");
      
     longitud = (o.length);
     for (j=0; j<longitud; j++)
       { 
       document.Register.provincia.options[j]=o[j];
       }      
      
    }
    // *********************************************************************************************
    //CASO DE PORTUGAL
    else if (indice==1)
     {

	  document.Register.provincia.length=1;
     
      longitud = (document.Register.provincia.length);
       for (j=0; j<longitud; j++)
         { 
           o[j]=new Option("","");
           document.Register.provincia.options[j]=o[j];
         }      
     
      o[i++]=new Option("[Escolhe um Distrito]","");
	  o[i++]=new Option("-------------------------------","");
	  o[i++]=new Option("Angra do Heroismo", "AH");      
      o[i++]=new Option("Aveiro", "AVE");
      o[i++]=new Option("Beja", "BE");
      o[i++]=new Option("Braga", "BRG");
      o[i++]=new Option("Bragan&ccedil;a", "BG");
      o[i++]=new Option("Castelo Branco", "CBR");
      o[i++]=new Option("Coimbra", "COI");
      o[i++]=new Option("Évora", "EV");
      o[i++]=new Option("Faro", "");
      o[i++]=new Option("Funchal", "FU");
      o[i++]=new Option("Guarda", "G");
      o[i++]=new Option("Horta", "HO");
      o[i++]=new Option("Leiria", "LI");
      o[i++]=new Option("Lisboa", "LB");
      o[i++]=new Option("Ponta Delgada", "PD");
      o[i++]=new Option("Portalegre", "PT");
      o[i++]=new Option("Porto", "PR");
      o[i++]=new Option("Santarém", "STR");
      o[i++]=new Option("Setúbal", "SB");
      o[i++]=new Option("Viana do Castelo", "VC");
      o[i++]=new Option("Vila Real", "VR");
      o[i++]=new Option("Viseu", "VS");
      
     longitud = (o.length);
     for (j=0; j<longitud; j++)
       { 
       document.Register.provincia.options[j]=o[j];
       }      
      
    } // END PORTUGAL    
    
    
    // ****************************************************************************************++
    // CASO DE MEXICO
    else if (indice==4)
     {

	  document.Register.provincia.length=1;
     
      longitud = (document.Register.provincia.length);
       for (j=0; j<longitud; j++)
         { 
           o[j]=new Option("","");
           document.Register.provincia.options[j]=o[j];
         }      
     
      o[i++]=new Option("[Elige una provincia]","");
	  o[i++]=new Option("-------------------------------","");
      o[i++]=new Option("Aguas Calientes", "AH");      
      o[i++]=new Option("Baja Calif S.", "BCS");
      o[i++]=new Option("Baja Calif", "BC");
      o[i++]=new Option("Campeche", "CAM");
      o[i++]=new Option("Chiapas", "CH");
      o[i++]=new Option("Chihuahua", "CHI");
      o[i++]=new Option("Ciudad de Mex", "CM");
      o[i++]=new Option("Coahuila", "COA");
      o[i++]=new Option("Colima", "CL");
      o[i++]=new Option("Durango", "DU");
      o[i++]=new Option("Estado de Mex.", "EM");
      o[i++]=new Option("Guanajuato", "GUJ");
      o[i++]=new Option("Guerrero", "GUE");
      o[i++]=new Option("Hidalgo", "HI");
      o[i++]=new Option("Sinaloa", "SI");
      o[i++]=new Option("Sonora", "SON");
      o[i++]=new Option("Tabasco", "TB");
      o[i++]=new Option("Tamaulipas", "TM");
      o[i++]=new Option("Tlaxcala", "TL");
      o[i++]=new Option("Veracruz", "VC");
      o[i++]=new Option("Yucatan", "YU");
      o[i++]=new Option("Zacatecas", "ZAC");
      o[i++]=new Option("Jalisco", "JA");
      o[i++]=new Option("Michon", "MI");
      o[i++]=new Option("Morelos", "MO");
      o[i++]=new Option("Nayarit", "NY");
      o[i++]=new Option("Nuevo Len", "NL");
      o[i++]=new Option("Oxaca", "OX");
      o[i++]=new Option("Puebla", "PU");
      o[i++]=new Option("Quertaro", "QA");
      o[i++]=new Option("Quintana Roo", "QR");
      o[i++]=new Option("Sn Luis P.", "SP");
      
     longitud = (o.length);
     for (j=0; j<longitud; j++)
       { 
       document.Register.provincia.options[j]=o[j];
       }      
     } // END MEXICO
    
    //************************************************************************************************
    
    
    // ****************************************************************************************++
    // CASO DE ARGENTINA
    else if (indice==5)
     {

	  document.Register.provincia.length=1;
     
      longitud = (document.Register.provincia.length);
       for (j=0; j<longitud; j++)
         { 
           o[j]=new Option("","");
           document.Register.provincia.options[j]=o[j];
         }      
     
      o[i++]=new Option("[Elige una provincia]","");
	  o[i++]=new Option("-------------------------------","");	  
      o[i++]=new Option("Charo", "CHA");      
      o[i++]=new Option("Chubut", "CB");
      o[i++]=new Option("C.Buenos Aires","CBA");
      o[i++]=new Option("Cordoba", "COR");
      o[i++]=new Option("Corrientes", "CRR");
      o[i++]=new Option("Entre Ros", "ER");
      o[i++]=new Option("Jujuy", "JJ");
      o[i++]=new Option("La Pampa","LP");
      o[i++]=new Option("La Rioja","LR");
      o[i++]=new Option("Mendoza","MZ");
      o[i++]=new Option("Misiones","MS");
      o[i++]=new Option("Neuqun", "NQ");
      o[i++]=new Option("Rio Negro", "RN");
      o[i++]=new Option("Salta", "ST");
      o[i++]=new Option("San Juan", "SJ");
      o[i++]=new Option("San Luis", "SL");
      o[i++]=new Option("Santa Cruz", "SC");
      o[i++]=new Option("Santa Fe", "SF");
      o[i++]=new Option("Santiago", "SAN");
      o[i++]=new Option("Tierra de F.", "TFU");
      o[i++]=new Option("Tucumn", "TU");


     longitud = (o.length);
     for (j=0; j<longitud; j++)
       { 
       document.Register.provincia.options[j]=o[j];
       }      
     } // END ARGENTINA
   // CASO DE BRASIL
    else if (indice==12)
     {
      
	  document.Register.provincia.length=1;
	  
      longitud = (document.Register.provincia.length);

       for (j=0; j<longitud; j++)
         { 
           o[j]=new Option("","");
           document.Register.provincia.options[j]=o[j];
         }      
     
      o[i++]=new Option("[Escolha um Estado]","");
	  o[i++]=new Option("-------------------------------","");
	  o[i++]=new Option("Acre", "ACR");      
      o[i++]=new Option("Alagoas", "ALA");
      o[i++]=new Option("Amapa","AMA");
      o[i++]=new Option("Amazonas", "AZ");
      o[i++]=new Option("Ceara", "CEA");
      o[i++]=new Option("Bahia", "BH");
      o[i++]=new Option("Distrito Federal", "DF");
      o[i++]=new Option("Espiritu Santo","ES");
      o[i++]=new Option("Golas","GL");
      o[i++]=new Option("Mato Grosso","MG");
      o[i++]=new Option("Mato G.Do Sul","MGS");
      o[i++]=new Option("Minas Gerais", "MN");
      o[i++]=new Option("Para", "PAA");
      o[i++]=new Option("Paraiba", "PRB");
      o[i++]=new Option("Parana", "PRN");
      o[i++]=new Option("Pernambuco", "PEA");
      o[i++]=new Option("Piaui", "PI");
      o[i++]=new Option("Rio de Janeiro", "RJ");
      o[i++]=new Option("Rio Grande N.", "RG");
      o[i++]=new Option("Rio Grande S.", "RGS");
      o[i++]=new Option("Rondonia", "RO");
      o[i++]=new Option("Roraima", "ROR");
      o[i++]=new Option("Santa Cat.", "STC");
      o[i++]=new Option("Sao Paulo", "SPA");
      o[i++]=new Option("Sergipe", "SER");
      o[i++]=new Option("Tocatins", "TOC");

     longitud = (o.length);
     for (j=0; j<longitud; j++)
       { 
       document.Register.provincia.options[j]=o[j];
       }      
     } // END Brasil
    else   // EL RESTO DE PAISES
     {

	  document.Register.provincia.length=1;

      longitud = (document.Register.provincia.length);

       for (j=0; j<longitud; j++)
         { 
           o[j]=  new Option("-------------------------------","ZZZ");
           document.Register.provincia.options[j]=o[j];
         }      
     }
     

  }

