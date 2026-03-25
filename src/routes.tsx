import { RouteObject } from 'react-router-dom';
import { lazy } from 'react';
import HomePage from './pages/index';

// Lazy load components for code splitting (except HomePage for instant loading)
const NotFoundPage = lazy(() => import('./pages/_404'));
const ServiciosPage = lazy(() => import('./pages/servicios'));
const GaleriaPage = lazy(() => import('./pages/galeria'));
const ContactoPage = lazy(() => import('./pages/contacto'));
const PrivacidadPage = lazy(() => import('./pages/privacidad'));
const TerminosPage = lazy(() => import('./pages/terminos'));

export const routes: RouteObject[] = [
  {
    path: '/',
    element: <HomePage />,
  },
  {
    path: '/servicios',
    element: <ServiciosPage />,
  },
  {
    path: '/galeria',
    element: <GaleriaPage />,
  },
  {
    path: '/contacto',
    element: <ContactoPage />,
  },
  {
    path: '/privacidad',
    element: <PrivacidadPage />,
  },
  {
    path: '/terminos',
    element: <TerminosPage />,
  },
  {
    path: '*',
    element: <NotFoundPage />,
  },
];

// Types for type-safe navigation
export type Path = '/' | '/servicios' | '/galeria' | '/contacto' | '/privacidad' | '/terminos';

export type Params = Record<string, string | undefined>;
