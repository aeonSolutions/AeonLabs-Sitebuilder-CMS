<?
class FileHeader {

	function getFileHeader($file_name) {
		$info = pathinfo($file_name);
		$extension = $info['extension'];
		
		$headers = FileHeader::getHeadersType();
		
		$header = $headers[$extension];
		return empty($header) ? "application/*" : $header;
	}
	
	function getHeadersType() {
	//http://www.utoronto.ca/webdocs/HTMLdocs/Book/Book-3ed/appb/mimetype.html#audi => contem todos os headers dos ficheiros existentes
		$headers = array();
		
		$headers["txt"] = "text/plain";
		$headers["c"] = "text/plain";
		$headers["c++"] = "text/plain";
		$headers["pl"] = "text/plain";
		$headers["cc"] = "text/plain";
		$headers["h"] = "text/plain";

		$headers["html"] = "text/html";
		$headers["htm"] = "text/html";
		$headers["xml"] = "text/xml";
		$headers["xsl"] = "text/xsl";
		$headers["css"] = "text/css";

		$headers["js"] = "text/javascript";
		$headers["ls"] = "text/javascript";
		$headers["mocha"] = "text/javascript";
		$headers["asp"] = "text/javascript";
		$headers["aspx"] = "text/javascript";
		$headers["php"] = "text/javascript";
		$headers["talk"] = "text/x-speech";
		
		$headers["gif"] = "image/gif";
		$headers["png"] = "image/x-png";
		$headers["ief"] = "image/ief";
		$headers["jpeg"] = "image/jpeg";
		$headers["jpg"] = "image/jpeg";
		$headers["jpe"] = "image/jpeg";
		$headers["bmp"] = "image/x-ms-bmp";
		$headers["tif"] = "image/tiff";
		$headers["tiff"] = "image/tiff";
		$headers["raw"] = "image/raw";
		$headers["psd"] = "image/psd";
		$headers["rgb"] = "image/rgb";
		$headers["g3f"] = "image/g3fax";
		$headers["xwd"] = "image/x-xwindowdump";
		$headers["pict"] = "image/x-pict";
		$headers["ppm"] = "image/x-portable-pixmap";
		$headers["pgm"] = "image/x-portable-graymap";
		$headers["pbm"] = "image/x-portable-bitmap";
		$headers["pnm"] = "image/x-portable-anymap";
		$headers["ras"] = "image/x-cmu-raster";
		$headers["pcd"] = "image/x-photo-cd";
		$headers["cgm"] = "image/cgm";
		$headers["fif"] = "image/fif";
		$headers["dsf"] = "image/x-mgx-dsf";
		$headers["cmx"] = "image/x-cmx";
		$headers["wi"] = "image/wavelet";
		$headers["dwg"] = "image/vnd.dwg";
		$headers["dxf"] = "image/vnd.dxf";
		$headers["svf"] = "image/vnd.svf";
		$headers["xbm"] = "image/x-xbitmap";
		$headers["xpm"] = "image/x-xpixmap";
		
		$headers["snd"] = "audio/basic";
		$headers["au"] = "audio/basic";
		$headers["aif"] = "audio/x-aiff";
		$headers["aiff"] = "audio/x-aiff";
		$headers["aifc"] = "audio/x-aiff";
		$headers["wav"] = "audio/x-wav";
		$headers["mpa"] = "audio/x-mpeg";
		$headers["abs"] = "audio/x-mpeg";
		$headers["mpega"] = "audio/x-mpeg";
		$headers["mp3"] = "audio/mp3";
		$headers["mp2a"] = "audio/x-mpeg-2";
		$headers["mpa2"] = "audio/x-mpeg-2";
		$headers["ra"] = "application/x-pn-realaudio";
		$headers["ram"] = "application/x-pn-realaudio";
		
		$headers["mpeg"] = "video/mpeg";
		$headers["mpe"] = "video/mpeg";
		$headers["mpg"] = "video/mpeg";
		$headers["mp2v"] = "video/mpeg-2";
		$headers["mpv2"] = "video/mpeg-2";
		$headers["mov"] = "video/quicktime";
		$headers["avi"] = "video/x-msvideo";
		$headers["movie"] = "video/x-sgi-movie";
		$headers["vdo"] = "video/vdo";
		$headers["viv"] = "video/vnd.vivo";
		
		$headers["pdf"] = "application/pdf";
		$headers["bin"] = "application/octet-stream";
		$headers["exe"] = "application/octet-stream";
		
		return $headers;
	}

}
?>