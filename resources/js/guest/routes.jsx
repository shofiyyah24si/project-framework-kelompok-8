// src/routes.jsx (contoh)
import Home from "@/pages/home";
import Warga from "@/pages/warga";
import Kejadian from "@/pages/kejadian";
import Posko from "@/pages/posko";

export const routes = [
  { name: "home", path: "/", element: <Home /> },
  { name: "warga", path: "/warga", element: <Warga /> },
  { name: "kejadian", path: "/kejadian", element: <Kejadian /> },
  { name: "posko", path: "/posko", element: <Posko /> },
];
