// Crear directorio para imágenes de perfil si no existe
import fs from "fs";
import path from "path";

const publicDir = "public/img";
if (!fs.existsSync(publicDir)) {
    fs.mkdirSync(publicDir, { recursive: true });
}
