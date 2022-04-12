import React, {useState} from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head } from '@inertiajs/inertia-react';
import AddEntry from "@/Pages/Entries/AddEntry";
import axios from 'axios';

export default function Index(props) {
    const [showModal, setShowModal] = useState(false);
    
    const [search, setSearch] = useState("");

    const [entries, setEntries] = useState(props.entries)
    const handleSearch =  (event) => {
        event.persist();
        var keyword = event.target.value;
        setSearch(event.target.value);
        if(keyword != '') {
            axios.get('/search?keyword=' + keyword)
            .then(function (response) {
                setEntries(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        } else {
            setEntries(props.entries);
        }
        
      };

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<div className="flex justify-between"><h2 className="font-semibold text-xl text-gray-800 leading-tight">Diary Entries</h2>
            <button className="px-4 py-2 bg-gray-900 text-gray-200 font-small items-end" onClick={() => setShowModal(true)}>Add Entry</button></div>}
        >

            <Head title="Diary Entries" />
            <div className="py-12">
                <div className="max-w-full mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                        <div className="flex">
                        <table className="min-w-full divide-y divide-gray-300">
                                <thead className="bg-gray-50">
                                <tr>
                                    <th scope="col" className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Daily Entry</th>
                                    <th scope="col" className="py-3.5 pl-3 pr-4 sm:pr-6">
                                        <input type="text" placeholder="Search" value={search} onChange={ handleSearch } />
                                    </th>
                                </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                            {entries ? (entries.data.map((entry, index)  => (  
                                <tr>
                                <td className="px-6 py-2 border-b border-gray-200 rounded-t-lg">{entry.entry}</td>
                                <td className="px-6 py-2 border-b border-gray-200 rounded-t-lg">Edit</td>
                                </tr>
                            ))) : <tr>No record found</tr> }
                            </tbody>

                        </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {showModal ? (
        <>
          <AddEntry modal={showModal}/>  
        </>
      ) : null}
        </Authenticated>
    );
}
