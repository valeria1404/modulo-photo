# -*- coding: utf-8 -*-
##############################################################################
#
#    OpenERP, Open Source Management Solution
#    Copyright (C) 2004-2010 Tiny SPRL (<http://tiny.be>).
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU Affero General Public License as
#    published by the Free Software Foundation, either version 3 of the
#    License, or (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU Affero General Public License for more details.
#
#    You should have received a copy of the GNU Affero General Public License
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
##############################################################################
from osv import fields, osv
from datetime import time, datetime



class photo(osv.osv):
	_name = "photo.all"
	_description = "visitas"
	_columns = {
	'name': fields.char('Nombre', size=128, required=True, select=True),
        'visit': fields.many2one('hr.employee', 'Nombre de a quien visita'),
        'reason': fields.text ('Motivo de la visita', size=58, required=True, select=True),
        'date': fields.datetime("Fecha"),
        'photo': fields.binary('Foto'),
        'photo_card': fields.binary('Foto credencial'),
        'photo_car': fields.binary('Foto de Vehículo'),
       

	}